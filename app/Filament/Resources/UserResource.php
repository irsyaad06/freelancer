<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 0;
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?string $navigationLabel = 'Admin';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(190),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->nullable()
                    ->maxLength(255),
                // Forms\Components\Select::make('role')
                //     ->options([
                //         'user' => 'User',
                //         'freelancer' => 'Freelancer',
                //         'admin' => 'Admin',
                //     ])
                //     ->default('freelancer')
                //     ->required(),
                Forms\Components\TextInput::make('no_whatsapp')
                    ->label('No. WhatsApp')
                    ->maxLength(20),
                // Forms\Components\FileUpload::make('profile_photo')
                //     ->image()
                //     ->directory('profile-photos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                // Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('no_whatsapp'),
                // Tables\Columns\ImageColumn::make('profile_photo'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
