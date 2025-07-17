<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebSettingResource\Pages;
use App\Filament\Resources\WebSettingResource\RelationManagers;
use App\Models\WebSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebSettingResource extends Resource
{
    protected static ?string $model = WebSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?int $navigationSort = 100;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo_web')
                    ->label('Logo Website')
                    ->directory('logos')
                    ->disk('public')
                    ->image()
                    ->visibility('public'),

                Forms\Components\TextInput::make('nama_web')
                    ->label('Nama Website')
                    ->required(),

                Forms\Components\Textarea::make('deskripsi_web')
                    ->label('Deskripsi'),

                Forms\Components\TextInput::make('alamat_web')
                    ->label('Alamat'),

                Forms\Components\TextInput::make('email_web')
                    ->label('Email'),

                Forms\Components\TextInput::make('telepon_web')
                    ->label('Telepon'),

                Forms\Components\TextInput::make('facebook_web')
                    ->label('Facebook'),

                Forms\Components\TextInput::make('instagram_web')
                    ->label('Instagram'),

                Forms\Components\TextInput::make('twitter_web')
                    ->label('Twitter'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_web')
                    ->label('Logo'),

                Tables\Columns\TextColumn::make('nama_web')->label('Nama'),
                Tables\Columns\TextColumn::make('email_web')->label('Email'),
                Tables\Columns\TextColumn::make('telepon_web')->label('Telepon'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebSettings::route('/'),
            'create' => Pages\CreateWebSetting::route('/create'),
            'view' => Pages\ViewWebSetting::route('/{record}'),
            'edit' => Pages\EditWebSetting::route('/{record}/edit'),
        ];
    }
}
