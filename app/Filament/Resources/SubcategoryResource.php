<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubcategoryResource\Pages;
use App\Filament\Resources\SubcategoryResource\RelationManagers;
use App\Models\Subcategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubcategoryResource extends Resource
{
    protected static ?string $model = Subcategory::class;
    public static function getModelLabel(): string
    {
        return 'Sub Kategori / Jasa';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sub Kategori / Jasa';
    }

    public static function getNavigationLabel(): string
    {
        return 'Sub Kategori / Jasa';
    }
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Manajemen Layanan';
    protected static ?string $navigationLabel = 'Jasa';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->required(),

                    Forms\Components\Repeater::make('subcategories')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label('Nama Sub Kategori'),
                        ])
                        ->label('Sub Kategori')
                        ->addActionLabel('Tambah Sub Kategori')
                        ->required()
                        ->columnSpanFull()
                        ->hiddenOn('edit'),

                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Nama Sub Kategori')
                        ->hiddenOn('create'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->searchable(),
                // Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Category')
                    ->multiple()
                    ->indicator('Category'),
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
            'index' => Pages\ListSubcategories::route('/'),
            'create' => Pages\CreateSubcategory::route('/create'),
            'edit' => Pages\EditSubcategory::route('/{record}/edit'),
        ];
    }
}
