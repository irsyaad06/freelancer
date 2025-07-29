<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    public static function getModelLabel(): string
    {
        return 'Pesanan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pesanan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pesanan';
    }

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('freelancer_id')
                    ->relationship('freelancer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Freelancer')
                    ->native(false),
                
                Forms\Components\Select::make('service_package_id')
                    ->relationship('package', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Paket Layanan')
                    ->native(false),
                
                Forms\Components\TextInput::make('buyer_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pembeli'),
                
                Forms\Components\TextInput::make('buyer_email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email Pembeli'),
                
                Forms\Components\TextInput::make('buyer_whatsapp')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->label('WhatsApp Pembeli'),
                
                Forms\Components\Textarea::make('job_description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Deskripsi Pekerjaan'),
                
                Forms\Components\FileUpload::make('attachment_file')
                    ->directory('order-attachments')
                    ->preserveFilenames()
                    ->downloadable()
                    ->label('File Lampiran'),
                
                Forms\Components\Select::make('status')
                    ->options(Order::getStatusOptions())
                    ->required()
                    ->default('pending')
                    ->label('Status')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                ->label('No')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('id_order')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('buyer_name')
                    ->label('Nama Pembeli')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->tooltip(fn(Order $record): string => $record->buyer_name),

                Tables\Columns\TextColumn::make('buyer_email')
                    ->label('Email')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(fn(Order $record): string => $record->buyer_email),

                Tables\Columns\TextColumn::make('buyer_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor WhatsApp disalin!'),

                // Tables\Columns\TextColumn::make('freelancer.name')
                //     ->label('Freelancer')
                //     ->searchable()
                //     ->sortable()
                //     ->limit(20)
                //     ->tooltip(fn (Order $record): string => $record->freelancer?->name ?? '-'),

                Tables\Columns\TextColumn::make('job_description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn(Order $record): string => $record->job_description),

                // Tables\Columns\TextColumn::make('status')
                //     ->label('Status')
                //     ->formatStateUsing(fn (string $state): string => Order::getStatusOptions()[$state] ?? $state)
                //     ->color(fn (string $state): string => match($state) {
                //         Order::STATUS_PENDING => 'warning',
                //         Order::STATUS_PROCESSING => 'primary',
                //         Order::STATUS_COMPLETED => 'success',
                //         Order::STATUS_CANCELLED => 'danger',
                //         default => 'secondary',
                //     })
                //     ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Ubah Status')
                    ->options(Order::getStatusOptions())
                    ->rules(['required'])
                    ->sortable()
                    ->afterStateUpdated(function ($state, $record) {
                        $record->update(['status' => $state]);
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                // Tables\Columns\SelectColumn::make('status')
                //     ->label('Ubah Status')
                //     ->options(Order::getStatusOptions())
                //     ->rules(['required'])
                //     ->sortable()
                //     ->afterStateUpdated(function ($state, $record) {
                //         $record->update(['status' => $state]);
                //     }),



                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Order::getStatusOptions())
                    ->label('Status'),

                // Tables\Filters\SelectFilter::make('freelancer')
                //     ->relationship('freelancer', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->label('Freelancer'),

                // Tables\Filters\SelectFilter::make('service_package')
                //     ->relationship('package', 'title')
                //     ->searchable()
                //     ->preload()
                //     ->label('Paket Layanan'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('change_status')
                        ->label('Ubah Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options(Order::getStatusOptions())
                                ->required()
                                ->label('Status Baru'),
                        ])
                        ->action(function (Order $record, array $data): void {
                            $record->update(['status' => $data['status']]);
                        })
                        ->modalHeading('Ubah Status Order')
                        ->modalButton('Simpan Perubahan'),

                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Detail Order'),

                    Tables\Actions\DeleteAction::make()
                        ->modalHeading(fn (Order $record) => 'Apakah yakin menghapus orderan ' . $record->id_order . '?'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('update_status')
                        ->label('Update Status Massal')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options(Order::getStatusOptions())
                                ->required()
                                ->label('Status Baru'),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each->update(['status' => $data['status']]);
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
