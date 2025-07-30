<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TermsAndConditions;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $freelancers = TermsAndConditions::all();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data freelancer',
            'data' => $freelancers
        ]);
    }
}
