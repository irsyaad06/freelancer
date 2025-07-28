<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreelancerResource\Pages;
use App\Filament\Resources\FreelancerResource\RelationManagers;
use App\Models\Freelancer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, Select, FileUpload, Toggle};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};

class FreelancerResource extends Resource
{
    protected static ?string $model = Freelancer::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Manajemen Layanan';
    protected static ?string $navigationLabel = 'Freelancer';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Nama')
                ->maxLength(255),
            Select::make('subcategories')
                ->label('Pilih Jasa')
                ->relationship('subcategories', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
            TextInput::make('email')
                ->email()
                ->maxLength(255),

            TextInput::make('phone_number')
                ->label('Nomor WhatsApp')
                ->tel(),

            FileUpload::make('profile_photo')
                ->label('Foto Profil')
                ->image()
                ->directory('freelancers/profile_photos'),

            Textarea::make('bio')
                ->label('Deskripsi / Bio')
                ->maxLength(1000)
                ->rows(4),

            TextInput::make('rating')
                ->numeric()
                ->step(0.1)
                ->minValue(0)
                ->maxValue(5),

            Toggle::make('is_verified')
                ->label('Terverifikasi'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('profile_photo')->label('Foto')->circular(),
            TextColumn::make('name')->searchable()->sortable()->label('Nama'),
            TextColumn::make('subcategories.name')->searchable()->sortable()->label('Jasa'),
            TextColumn::make('email')->sortable(),
            TextColumn::make('phone_number')->label('WhatsApp'),
            TextColumn::make('rating')->sortable(),
            IconColumn::make('is_verified')
                ->label('Verified')
                ->boolean(),
        ])->defaultSort('name')
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
            'index' => Pages\ListFreelancers::route('/'),
            'create' => Pages\CreateFreelancer::route('/create'),
            'edit' => Pages\EditFreelancer::route('/{record}/edit'),
        ];
    }
}
