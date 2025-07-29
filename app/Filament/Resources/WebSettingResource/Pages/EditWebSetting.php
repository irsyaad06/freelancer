<?php

namespace App\Filament\Resources\WebSettingResource\Pages;

use App\Filament\Resources\WebSettingResource;
use App\Models\WebSetting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebSetting extends EditRecord
{
    protected static string $resource = WebSettingResource::class;
        protected function getRedirectUrl(): string
    {
        return WebSettingResource::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
