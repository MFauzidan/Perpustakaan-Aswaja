<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;
    protected function afterCreate(): void
{
    $record = $this->record;

    // Set jumlah_sekarang sama dengan jumlah_asli saat buku dibuat
    $record->update([
        'jumlah_sekarang' => $record->jumlah_asli,
    ]);
}
    
}
