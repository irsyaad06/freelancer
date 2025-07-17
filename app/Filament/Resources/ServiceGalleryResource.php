<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceGalleryResource\Pages;
use App\Filament\Resources\ServiceGalleryResource\RelationManagers;
use App\Models\ServiceGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceGalleryResource extends Resource
{
    protected static ?string $model = ServiceGallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Manajemen Layanan';
    protected static ?string $navigationLabel = 'Galeri Layanan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->label('Gambar')
                        ->disk('public')
                        ->directory('service-galleries')
                        ->required(),

                    Forms\Components\Select::make('service_id')
                        ->relationship('service', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')->searchable()->rowIndex(),
                Tables\Columns\TextColumn::make('service.title')->label('Service'),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public'),

            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListServiceGalleries::route('/'),
            'create' => Pages\CreateServiceGallery::route('/create'),
            'edit' => Pages\EditServiceGallery::route('/{record}/edit'),
        ];
    }
}
