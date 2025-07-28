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
        $layanan = ServicePackage::with(['freelancer', 'subcategory', 'services'])->get();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data Freelancer',
            'data' => $layanan
        ]);
    }

    /**
     * Display the specified service package with its service
     */
    public function show($id)
    {
        try {
            $package = ServicePackage::with(['freelancer', 'subcategory', 'services'])->find($id);

            if (!$package) {
                return response()->json(['message' => 'Package not found'], 404);
            }

            // Manually construct the response to ensure correct JSON structure
            $data = [
                'id' => $package->id,
                'title' => $package->title,
                'description' => $package->description,
                'freelancer' => [
                    'id' => $package->freelancer->id,
                    'name' => $package->freelancer->name,
                ],
                'subcategory' => [
                    'name' => $package->subcategory->name,
                ],
                'services' => $package->services->map(function ($service) {
                    return [
                        'title' => $service->title,
                    ];
                }),
            ];

            return response()->json(['data' => $data]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching package details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
