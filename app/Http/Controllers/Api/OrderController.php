<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['freelancer', 'package'])->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'freelancer_id' => 'required|exists:freelancers,id',
            'service_package_id' => 'required|exists:service_packages,id',
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'buyer_whatsapp' => 'required|string|max:20',
            'job_description' => 'required|string',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        $validated['status'] = 'pending';

        if ($request->hasFile('attachment_file')) {
            $path = $request->file('attachment_file')->store('order_attachments', 'public');
            $validated['attachment_file'] = $path;
        }

        // Generate id_order
        $prefix = 'PS-' . now()->format('Ym') . '-';
        $latestOrder = Order::where('id_order', 'like', $prefix . '%')->latest()->first();

        if ($latestOrder) {
            $lastNumber = (int) substr($latestOrder->id_order, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $validated['id_order'] = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Create order
        $order = Order::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order->load(['freelancer', 'package'])
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['freelancer', 'package'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'deadline' => 'sometimes|required|date|after:today',
            'notes' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed,cancelled'
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order->load(['freelancer', 'package'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }
}
