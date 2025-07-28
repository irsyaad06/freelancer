<?php

namespace App\Filament\Resources\SubcategoryResource\Pages;

use App\Filament\Resources\SubcategoryResource;
use App\Models\Subcategory;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSubcategory extends CreateRecord
{
    protected static string $resource = SubcategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return SubcategoryResource::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $categoryId = $data['category_id'];
        $subcategories = $data['subcategories'] ?? [];
        
        $createdRecords = [];
        
        foreach ($subcategories as $subcategoryData) {
            $createdRecords[] = Subcategory::create([
                'category_id' => $categoryId,
                'name' => $subcategoryData['name'],
            ]);
        }
        
        // Return the last created record for redirect
        return end($createdRecords);
    }
}
