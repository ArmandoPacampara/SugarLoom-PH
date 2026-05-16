<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Submit a rating for a delivered order
     */
    public function submitRating(Request $request, Order $order)
    {
        if (! auth()->check() || $order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the rating submission
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_comment' => 'nullable|string|max:500',
        ]);

        if ($order->status !== Order::STATUS_DELIVERED) {
            return redirect()->back()->with('error', 'Only delivered orders can be rated.');
        }

        if ($order->rating || $order->reviewed_at) {
            return redirect()->back()->with('error', 'This order has already been reviewed.');
        }

        $rewardPoints = (int) config('sugarloom.rewards.review_points', 25);

        DB::transaction(function () use ($order, $validated, $rewardPoints) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if ($lockedOrder->rating || $lockedOrder->reviewed_at) {
                return;
            }

            $lockedOrder->update([
                'rating' => $validated['rating'],
                'review_comment' => $validated['review_comment'] ?? null,
                'reviewed_at' => now(),
                'review_reward_points_awarded' => true,
                'review_reward_points' => $rewardPoints,
            ]);

            if ($rewardPoints > 0 && $lockedOrder->user) {
                $lockedOrder->user->increment('reward_points', $rewardPoints);
            }

            // Recalculate ratings for all products in this order
            $lockedOrder->items->each(function ($item) {
                if ($item->product) {
                    $item->product->updateAverageRating();
                }
            });
        });

        return redirect()->back()->with('success', "Thank you for your rating! {$rewardPoints} reward points were added to your account.");
    }
}
