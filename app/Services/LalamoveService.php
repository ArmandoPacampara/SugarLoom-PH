<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class LalamoveService
{
    public function quote(array $customer, $cartItems): array
    {
        $apiKey = config('services.lalamove.api_key');
        $apiSecret = config('services.lalamove.api_secret');
        $pickupLat = config('services.lalamove.pickup_lat');
        $pickupLng = config('services.lalamove.pickup_lng');

        if (blank($apiKey) || blank($apiSecret)) {
            throw new RuntimeException('Lalamove API credentials are not configured.');
        }

        if (blank($pickupLat) || blank($pickupLng)) {
            throw new RuntimeException('Store pickup coordinates are not configured.');
        }

        $path = '/v3/quotations';
        $payload = [
            'data' => [
                'serviceType' => config('services.lalamove.service_type', 'MOTORCYCLE'),
                'language' => config('services.lalamove.language', 'en_PH'),
                'stops' => [
                    [
                        'coordinates' => [
                            'lat' => (string) $pickupLat,
                            'lng' => (string) $pickupLng,
                        ],
                        'address' => config('services.lalamove.pickup_address', 'SugarLoom PH'),
                    ],
                    [
                        'coordinates' => [
                            'lat' => (string) $customer['delivery_lat'],
                            'lng' => (string) $customer['delivery_lng'],
                        ],
                        'address' => $this->deliveryAddress($customer),
                    ],
                ],
                'item' => [
                    'quantity' => (string) collect($cartItems)->sum('quantity'),
                    'weight' => 'LESS_THAN_3KG',
                    'categories' => ['FOOD_DELIVERY'],
                    'handlingInstructions' => ['KEEP_UPRIGHT'],
                ],
            ],
        ];

        $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $timestamp = (string) (int) floor(microtime(true) * 1000);
        $signature = hash_hmac('sha256', "{$timestamp}\r\nPOST\r\n{$path}\r\n\r\n{$body}", $apiSecret);

        $response = Http::withHeaders([
            'Authorization' => "hmac {$apiKey}:{$timestamp}:{$signature}",
            'Content-Type' => 'application/json',
            'Market' => config('services.lalamove.market', 'PH'),
            'Request-ID' => (string) Str::uuid(),
        ])
            ->acceptJson()
            ->withBody($body, 'application/json')
            ->post(rtrim(config('services.lalamove.base_url'), '/') . $path);

        if ($response->failed()) {
            report('Lalamove quotation failed: ' . $response->body());
            throw new RuntimeException($response->json('message') ?: 'Unable to compute delivery fee right now.');
        }

        $data = $response->json('data', []);
        $fee = (float) data_get($data, 'priceBreakdown.total', 0);

        if ($fee <= 0 || blank(data_get($data, 'quotationId'))) {
            report('Lalamove quotation returned an unexpected response: ' . $response->body());
            throw new RuntimeException('Lalamove did not return a valid delivery quote.');
        }

        return [
            'quotation_id' => data_get($data, 'quotationId'),
            'delivery_fee' => round($fee, 2),
            'currency' => data_get($data, 'priceBreakdown.currency', 'PHP'),
            'distance' => data_get($data, 'distance.value'),
            'expires_at' => now()->addMinutes(5),
        ];
    }

    private function deliveryAddress(array $customer): string
    {
        return collect([
            $customer['shipping_address'] ?? null,
            $customer['city'] ?? null,
            $customer['postal_code'] ?? null,
            'Philippines',
        ])->filter()->join(', ');
    }
}
