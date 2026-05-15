<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AddressValidationService
{
    public function validate(string $address, string $city, string $postalCode): array
    {
        if (! config('sugarloom.address_validation.enabled')) {
            return [
                'status' => 'skipped',
                'message' => 'Address validation is not enabled.',
                'valid' => true,
            ];
        }

        if (config('sugarloom.address_validation.provider') !== 'nominatim') {
            return [
                'status' => 'skipped',
                'message' => 'Configured address validation provider is not supported yet.',
                'valid' => true,
            ];
        }

        $query = "{$address}, {$city}, Metro Manila, {$postalCode}, Philippines";

        try {
            $results = Http::withHeaders([
                'User-Agent' => 'SugarLoomPH/1.0',
            ])
                ->timeout(5)
                ->get(config('sugarloom.address_validation.endpoint'), [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                    'addressdetails' => 1,
                ])
                ->json();
        } catch (\Throwable) {
            return [
                'status' => 'unverified',
                'message' => 'We could not verify the address right now. You can continue by confirming it manually.',
                'valid' => false,
            ];
        }

        if (! empty($results)) {
            return [
                'status' => 'verified',
                'message' => 'Address verified.',
                'valid' => true,
            ];
        }

        return [
            'status' => 'invalid',
            'message' => 'We could not find that address. Check it or confirm that you want to use it anyway.',
            'valid' => false,
        ];
    }
}
