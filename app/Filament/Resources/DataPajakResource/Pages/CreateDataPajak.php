<?php

namespace App\Filament\Resources\DataPajakResource\Pages;

use App\Filament\Resources\DataPajakResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDataPajak extends CreateRecord
{
    protected static string $resource = DataPajakResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // redirect ke halaman list data pajak
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Data Pajak berhasil ditambahkan!')
            ->success()
            ->duration(3000) // opsional: tampil selama 3 detik
            ->send();
    }
}
