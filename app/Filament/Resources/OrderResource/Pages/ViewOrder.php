<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Order')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('id_order')
                                        ->label('Order ID')
                                        ->size('lg')
                                        ->weight('bold'),
                                    
                                    TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'pending' => 'warning',
                                            'in_progress' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'gray',
                                        }),
                                    
                                    TextEntry::make('created_at')
                                        ->label('Tanggal Order')
                                        ->dateTime('d F Y H:i')
                                        ->size('sm'),
                                    
                                    TextEntry::make('updated_at')
                                        ->label('Terakhir Diperbarui')
                                        ->dateTime('d F Y H:i')
                                        ->size('sm'),
                                ]),
                                
                                Group::make([
                                    TextEntry::make('package.title')
                                        ->label('Paket Layanan')
                                        ->size('lg')
                                        ->weight('bold'),
                                    
                                    TextEntry::make('package.price')
                                        ->label('Harga')
                                        ->money('IDR')
                                        ->size('sm'),
                                    
                                    TextEntry::make('freelancer.name')
                                        ->label('Freelancer')
                                        ->size('sm'),
                                ]),
                            ]),
                    ]),
                
                Section::make('Informasi Pembeli')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('buyer_name')
                                        ->label('Nama Lengkap')
                                        ->size('base'),
                                    
                                    TextEntry::make('buyer_email')
                                        ->label('Email')
                                        ->size('base'),
                                    
                                    TextEntry::make('buyer_whatsapp')
                                        ->label('Nomor WhatsApp')
                                        ->size('base'),
                                ]),
                                
                                Group::make([
                                    TextEntry::make('job_description')
                                        ->label('Deskripsi Pekerjaan')
                                        ->size('base')
                                        ->columnSpanFull()
                                        ->html(),
                                ]),
                            ]),
                    ]),
                
                Section::make('Detail Freelancer')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('freelancer.name')
                                        ->label('Nama Freelancer')
                                        ->size('lg')
                                        ->weight('bold'),
                                    
                                    TextEntry::make('freelancer.email')
                                        ->label('Email')
                                        ->size('base'),
                                    
                                    TextEntry::make('freelancer.phone_number')
                                        ->label('Nomor Telepon')
                                        ->size('base'),
                                    
                                    TextEntry::make('freelancer.rating')
                                        ->label('Rating')
                                        ->size('base')
                                        ->suffix('/5.0'),
                                ]),
                                
                                Group::make([
                                    TextEntry::make('freelancer.bio')
                                        ->label('Bio')
                                        ->size('base')
                                        ->columnSpanFull(),
                                    
                                    ImageEntry::make('freelancer.profile_photo')
                                        ->label('Foto Profil')
                                        ->size(100)
                                        ->circular(),
                                ]),
                            ]),
                    ]),
                
                Section::make('File Lampiran')
                    ->schema([
                        TextEntry::make('attachment_file')
                            ->label('File Attachment')
                            ->badge()
                            ->color('primary')
                            ->url(fn(?string $state): ?string => $state ? \Illuminate\Support\Facades\Storage::url($state) : null, true)
                            ->formatStateUsing(fn (?string $state): ?string => $state ? 'Klik untuk melihat/mengunduh file' : null)
                            ->hidden(fn(?Order $record): bool => ! $record?->attachment_file),
                    ])
                    ->hidden(fn(?Order $record): bool => ! $record?->attachment_file),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->label('Ubah Status')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\Select::make('status')
                        ->options(\App\Models\Order::getStatusOptions())
                        ->required()
                        ->label('Status Baru'),
                ])
                ->action(function (array $data): void {
                    $this->record->update(['status' => $data['status']]);
                })
                ->modalHeading('Ubah Status Order')
                ->modalButton('Simpan Perubahan'),
            Actions\DeleteAction::make(),
        ];
    }
}
