<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Submit a rating for a delivered order
     */
    public function submitRating(Request $request, Order $order)
    {
        // Verify the order belongs to the authenticated user or is a guest order
        if ($order->user_id && $order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the rating submission
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_comment' => 'nullable|string|max:500',
        ]);

        // Check if order is delivered
        if ($order->status !== Order::STATUS_DELIVERED) {
            return redirect()->back()->with('error', 'Only delivered orders can be rated.');
        }

        // Update the order with rating and timestamp
        $order->update([
            'rating' => $validated['rating'],
            'review_comment' => $validated['review_comment'] ?? null,
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your rating!');
    }
}
