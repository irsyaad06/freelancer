<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    /**
     * Display a listing of all service packages with their service
     */
    public function index()
    {
        try {
            $packages = ServicePackage::with(relations: ['service' => function($query) {
                $query->select('service.id', 'service.title', 'service.description', 'service.price', 'service.delivery_time');
            }])
            ->select('id', 'name', 'description', 'price', 'duration', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

            return response()->json([
                'code' => 200,
                'message' => 'Service packages retrieved successfully',
                'data' => $packages->map(function($package) {
                    return [
                        'id' => $package->id,
                        'name' => $package->name,
                        'description' => $package->description,
                        'price' => $package->price,
                        'duration' => $package->duration,
                        'service' => $package->service->map(function($service) {
                            return [
                                'id' => $service->id,
                                'title' => $service->title,
                                'description' => $service->description,
                                'price' => $service->price,
                                'delivery_time' => $service->delivery_time,
                                'quantity' => $service->pivot->quantity
                            ];
                        })
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to fetch service packages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified service package with its service
     */
    public function show(string $id)
    {
        try {
            $package = ServicePackage::with(['service' => function($query) {
                $query->select('service.id', 'service.title', 'service.description', 'service.price', 'service.delivery_time')
                      ->withPivot('quantity');
            }])
            ->select('id', 'name', 'description', 'price', 'duration', 'created_at')
            ->findOrFail($id);

            return response()->json([
                'code' => 200,
                'message' => 'Service package retrieved successfully',
                'data' => [
                    'id' => $package->id,
                    'name' => $package->name,
                    'description' => $package->description,
                    'price' => $package->price,
                    'duration' => $package->duration,
                    'service' => $package->service->map(function($service) {
                        return [
                            'id' => $service->id,
                            'title' => $service->title,
                            'description' => $service->description,
                            'price' => $service->price,
                            'delivery_time' => $service->delivery_time,
                            'quantity' => $service->pivot->quantity
                        ];
                    })
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Service package not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to fetch service package: ' . $e->getMessage()
            ], 500);
        }
    }
}