<?php

namespace App\Filament\Resources\FreelancerPhotoResource\Pages;

use App\Filament\Resources\FreelancerPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFreelancerPhoto extends CreateRecord
{
    protected static string $resource = FreelancerPhotoResource::class;
    protected function getRedirectUrl(): string
    {
        return FreelancerPhotoResource::getUrl('index');
    }
}
