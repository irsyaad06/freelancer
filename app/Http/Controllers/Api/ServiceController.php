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
            'code' => 200,
            'message' => 'Berhasil mendapatkan data layanan',
            'data' => $services
        ]);
    }

    // GET /api/services/{id}
    public function show($id)
    {
        $service = Service::with('gallery')->find($id);

        if (!$service) {
            return response()->json([
                'code' => 404,
                'message' => 'Layanan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan detail layanan',
            'data' => $service
        ]);
    }
}
