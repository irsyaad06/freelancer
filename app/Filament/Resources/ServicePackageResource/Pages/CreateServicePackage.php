<?php

namespace App\Filament\Resources\ServicePackageResource\Pages;

use App\Filament\Resources\ServicePackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateServicePackage extends CreateRecord
{
    protected static string $resource = ServicePackageResource::class;
    protected function getRedirectUrl(): string
    {
        return ServicePackageResource::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $freelancerId = $data['freelancer_id'] ?? null;

        // Inject freelancer_id ke semua layanan
        if (isset($data['services'])) {
            $data['services'] = collect($data['services'])->map(function ($service) use ($freelancerId) {
                $service['freelancer_id'] = $freelancerId;
                return $service;
            })->toArray();
        }


        return $data;
    }
}
