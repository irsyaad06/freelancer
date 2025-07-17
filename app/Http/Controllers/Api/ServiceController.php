<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/services
    public function index()
    {
        $services = Service::with('gallery')->get();

        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    // GET /api/services/{id}
    public function show($id)
    {
        $service = Service::with('gallery')->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }
}
