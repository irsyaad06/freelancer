<?php

namespace App\Filament\Resources\FreelancerPhotoResource\Pages;

use App\Filament\Resources\FreelancerPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreelancerPhoto extends EditRecord
{
    protected static string $resource = FreelancerPhotoResource::class;
    protected function getRedirectUrl(): string
    {
        return FreelancerPhotoResource::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
