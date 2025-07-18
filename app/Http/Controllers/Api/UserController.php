<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of freelancers.
     */
    public function index()
    {
        $freelancers = User::where('role', 'freelancer')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data freelancer',
            'data' => $freelancers
        ]);
    }

    public function show(string $id)
    {
        $freelancer = User::where('role', 'freelancer')->find($id);

        if (!$freelancer) {
            return response()->json([
                'code' => 404,
                'message' => 'Freelancer tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan detail freelancer',
            'data' => $freelancer
        ]);
    }
}
