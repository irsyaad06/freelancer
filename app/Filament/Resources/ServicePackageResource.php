<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePackageResource\Pages;
use App\Filament\Resources\ServicePackageResource\RelationManagers;
use App\Models\ServicePackage;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Freelancer;
use App\Models\Subcategory;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\TextColumn;

class ServicePackageResource extends Resource
{
    protected static ?string $model = ServicePackage::class;
    public static function getModelLabel(): string
    {
        return 'Paket';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Paket';
    }

    public static function getNavigationLabel(): string
    {
        return 'Paket';
    }

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Manajemen Layanan';
    protected static ?string $navigationLabel = 'Paket';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                Select::make('title')
                    ->label('Judul Paket')
                    ->options([
                        'starter' => 'Starter',
                        'standard' => 'Standard',
                        'premium' => 'Premium',
                    ])
                    ->required()
                    ->native(false),


                TextInput::make('price')
                    ->label('Harga Paket')
                    ->numeric()
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable(),

                Repeater::make('services')
                    ->label('Layanan')
                    ->relationship()
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Layanan')
                            ->required(),
                    ])
                    ->columnSpan('full')
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Layanan')
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, \Filament\Forms\Get $get): array {
                        $data['freelancer_id'] = $get('freelancer_id');
                        $data['subcategory_id'] = $get('subcategory_id');
                        return $data;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('freelancer.name')
                    ->label('Freelancer')
                    ->collapsible(),
            ])
            ->defaultGroup('freelancer.name')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul Paket')->searchable()->color(fn(string $state): string => match ($state) {
                    'starter' => 'gray',
                    'standard' => 'warning',
                    'premium' => 'success',
                })->badge(),
                Tables\Columns\TextColumn::make('freelancer.name')->label('Freelancer'),
                Tables\Columns\TextColumn::make('subcategory.name')->label('Subkategori'),
                Tables\Columns\TextColumn::make('price')->label('Harga'),
                Tables\Columns\TextColumn::make('services_count')
                    ->counts('services')
                    ->label('Jumlah Layanan'),
            ])
            ->defaultSort('subcategory_id', 'desc')
            ->filters([])
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
            'index' => Pages\ListServicePackages::route('/'),
            'create' => Pages\CreateServicePackage::route('/create'),
            'edit' => Pages\EditServicePackage::route('/{record}/edit'),
        ];
    }
}
