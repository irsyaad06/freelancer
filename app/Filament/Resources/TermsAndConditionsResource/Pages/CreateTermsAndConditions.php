<?php

namespace App\Filament\Resources\TermsAndConditionsResource\Pages;

use App\Filament\Resources\TermsAndConditionsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTermsAndConditions extends CreateRecord
{
    protected static string $resource = TermsAndConditionsResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
