<?php

namespace App\Filament\Resources\WebSettingResource\Pages;

use App\Filament\Resources\WebSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebSettings extends ListRecords
{
    protected static string $resource = WebSettingResource::class;

    public function mount(): void
    {
        $setting = \App\Models\WebSetting::first();
        if ($setting) {
            $this->redirect(static::getResource()::getUrl('edit', ['record' => $setting->id]));
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
