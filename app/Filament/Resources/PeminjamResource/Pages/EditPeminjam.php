<?php

namespace App\Filament\Resources\PeminjamResource\Pages;

use App\Filament\Resources\PeminjamResource;
use App\Models\Buku;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjam extends EditRecord
{
    protected static string $resource = PeminjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function ($record) {
                    // Saat hapus, balikin stok
                    $buku = Buku::find($record->id_buku);
                    if ($buku) {
                        $buku->jumlah_asli += $record->jumlah_pinjam;
                        $buku->save();
                    }
                }),
        ];
    }

    protected function beforeSave(): void
    {
        $record = $this->record->fresh(); // data lama di DB
        $oldJumlah = $record->jumlah_pinjam;
        $buku = Buku::find($record->id_buku);

        if ($buku) {
            $buku->jumlah_asli += $oldJumlah; // balikin stok lama
            $buku->save();
        }
    }

    protected function afterSave(): void
    {
        $record = $this->record; // data update baru
        $buku = Buku::find($record->id_buku);

        if ($buku) {
            $buku->jumlah_asli -= $record->jumlah_pinjam; // kurangi sesuai baru
            $buku->save();
        }
    }
}
