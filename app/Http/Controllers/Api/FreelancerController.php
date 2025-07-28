<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Freelancer;

class FreelancerController extends Controller
{
    public function index()
    {
        $freelancer = Freelancer::with(['servicePackages' => function ($query) {
            $query->select('id', 'freelancer_id', 'price')->orderBy('price', 'asc');
        }])->get([
            'id',
            'name',
            'profile_photo',
            'rating',
            'is_verified'
        ])->map(function ($item) {
            $minPrice = $item->servicePackages->min('price');
            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'profile_photo' => $item->profile_photo,
                'rating'        => $item->rating,
                'is_verified'   => $item->is_verified ? 'Verified' : 'Unverified',
                'price'         => $minPrice ? (int) $minPrice : 0,
            ];
        });

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data Freelancer',
            'data' => $freelancer
        ]);
    }

    public function freelancerBySubcategory(Request $request, $subcategory_id)
    {
        $freelancer = Freelancer::whereHas('subcategories', function ($query) use ($subcategory_id) {
            $query->where('subcategories.id', $subcategory_id);
        })->with(['servicePackages' => function ($query) {
            $query->select('id', 'freelancer_id', 'price')->orderBy('price', 'asc');
        }])->get([
            'id',
            'name',
            'profile_photo',
            'rating',
            'is_verified'
        ])->map(function ($item) {
            $minPrice = $item->servicePackages->min('price');
            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'profile_photo' => $item->profile_photo,
                'rating'        => $item->rating,
                'is_verified'   => $item->is_verified ? 'Verified' : 'Unverified',
                'price'         => $minPrice ? (int) $minPrice : 0,
            ];
        });

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data Freelancer',
            'data' => $freelancer
        ]);
    }

    public function freelancerDetailBySubcategory($subcategory_id, $freelancer_id)
    {
        $freelancer = Freelancer::with([
        'servicePackages' => function ($q) use ($subcategory_id) {
            $q->where('subcategory_id', $subcategory_id);
        },
        'servicePackages.services',
        'servicePackages.subcategory.category',
        'photos'
    ])->findOrFail($freelancer_id);

    $filteredPackages = $freelancer->servicePackages;

    $response = [
        'code' => 200,
        'message' => 'Berhasil mendapatkan detail freelancer',
        'data' => [
            'kategori' => $filteredPackages->first()->subcategory->category->name ?? null,
            'subkategori' => $filteredPackages->first()->subcategory->name ?? null,
            'freelancer' => [
                'id' => $freelancer->id,
                'name' => $freelancer->name,
                'profile_photo' => $freelancer->profile_photo,
                'rating' => $freelancer->rating,
                'is_verified' => $freelancer->is_verified ? 'Verified' : 'Unverified',
                'photos' => $freelancer->photos->map(function ($photo) {
                    return [
                        'id' => $photo->id,
                        'image' => $photo->image_path,
                        'caption' => $photo->title,
                    ];
                }),
            ],
            'servicePackages' => $filteredPackages->map(function ($package) {
                return [
                    'id' => $package->id,
                    'name' => $package->title,
                    'price' => $package->price,
                    'description' => $package->description,
                    'services' => $package->services->map(function ($service) {
                        return [
                            'id' => $service->id,
                            'name' => $service->title,
                        ];
                    })
                ];
            })
        ]
    ];

    return response()->json($response);
    }
}
