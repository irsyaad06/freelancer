<?php

namespace App\Filament\Resources\FreelancerPhotoResource\Pages;

use App\Filament\Resources\FreelancerPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreelancerPhotos extends ListRecords
{
    protected static string $resource = FreelancerPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
