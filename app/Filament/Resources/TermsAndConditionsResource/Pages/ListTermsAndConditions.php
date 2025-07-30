<?php

namespace App\Filament\Resources\TermsAndConditionsResource\Pages;

use App\Filament\Resources\TermsAndConditionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermsAndConditions extends ListRecords
{
    protected static string $resource = TermsAndConditionsResource::class;

    public function mount(): void
    {
        $terms = \App\Models\TermsAndConditions::first();
        if ($terms) {
            $this->redirect(static::getResource()::getUrl('edit', ['record' => $terms->id]));
            return;
        }
        $this->redirect(static::getResource()::getUrl('create'));
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
