<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreelancerPhotoResource\Pages;
use App\Filament\Resources\FreelancerPhotoResource\RelationManagers;
use App\Models\FreelancerPhoto;
use App\Models\Freelancer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class FreelancerPhotoResource extends Resource
{
    public static function getModelLabel(): string
    {
        return 'Galeri Layanan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Galeri Layanan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Galeri Layanan';
    }

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Manajemen Layanan';
    protected static ?string $navigationLabel = 'Galeri Layanan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('freelancer_id')
                ->label('Freelancer')
                ->options(Freelancer::all()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive(),

            Select::make('subcategory_id')
                ->label('Subkategori')
                ->options(function (callable $get) {
                    $freelancerId = $get('freelancer_id');
                    if (!$freelancerId) {
                        return [];
                    }

                    // Ambil subkategori dari freelancer yang dipilih
                    $freelancer = \App\Models\Freelancer::with('subcategories')->find($freelancerId);
                    return $freelancer?->subcategories?->pluck('name', 'id') ?? [];
                })
                ->searchable()
                ->required()
                ->disabled(fn(callable $get) => !$get('freelancer_id')),

            TextInput::make('title')
                ->label('Judul Foto')
                ->required(),

            FileUpload::make('image_path')
                ->label('Foto')
                ->image()
                ->directory('freelancer-photos')
                ->required(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('freelancer.name')
            ->groups([
                Tables\Grouping\Group::make('freelancer_and_subcategory')
                    ->label('Freelancer & Subkategori')
                    ->getTitleFromRecordUsing(function ($record) {
                        return $record->freelancer->name . ' & ' . $record->subcategory->name;
                    })
                    ->orderQueryUsing(function (Builder $query, string $direction) {
                        return $query
                            ->join('freelancers', 'freelancer_photos.freelancer_id', '=', 'freelancers.id')
                            ->join('subcategories', 'freelancer_photos.subcategory_id', '=', 'subcategories.id')
                            ->orderBy('freelancers.name', $direction)
                            ->orderBy('subcategories.name', $direction);
                    }),
            ])
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Foto')
                    ->size(100),
                TextColumn::make('freelancer.name')
                    ->label('Freelancer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subcategory.name')
                    ->label('Sub Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subcategory')
                    ->relationship('subcategory', 'name')
                    ->label('Filter Sub Kategori')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFreelancerPhotos::route('/'),
            'create' => Pages\CreateFreelancerPhoto::route('/create'),
            'edit' => Pages\EditFreelancerPhoto::route('/{record}/edit'),
        ];
    }
}
