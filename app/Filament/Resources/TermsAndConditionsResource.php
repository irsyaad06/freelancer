<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermsAndConditionsResource\Pages;
use App\Filament\Resources\TermsAndConditionsResource\RelationManagers;
use App\Models\TermsAndConditions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TermsAndConditionsResource extends Resource
{
    protected static ?string $model = TermsAndConditions::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Syarat & Ketentuan';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?string $modelLabel = 'Syarat & Ketentuan';
    protected static ?string $pluralModelLabel = 'Syarat & Ketentuan';
    protected static ?int $navigationSort = 90;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('content')
                    ->label('Isi Syarat & Ketentuan')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('terms-attachments')
                    ->disableAllToolbarButtons()
                    ->enableToolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'h1',
                        'h2',
                        'h3',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'bulletList',
                        'orderedList',
                        'link',
                        'media',
                        'table',
                        'code',
                        'codeBlock',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Syarat & Ketentuan'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTermsAndConditions::route('/'),
            'create' => Pages\CreateTermsAndConditions::route('/create'),
            'edit' => Pages\EditTermsAndConditions::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return TermsAndConditions::count() === 0;
    }
    
    public static function canDeleteAny(): bool
    {
        return false;
    }
}
