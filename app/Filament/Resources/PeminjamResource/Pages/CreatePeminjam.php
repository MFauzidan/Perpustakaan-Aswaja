<?php

namespace App\Filament\Resources\PeminjamResource\Pages;

use App\Filament\Resources\PeminjamResource;
use App\Models\Buku;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePeminjam extends CreateRecord
{
    protected static string $resource = PeminjamResource::class;

    protected function beforeCreate(): void
    {
        $jumlahPinjam = $this->form->getState()['jumlah_pinjam'];
        $buku = Buku::find($this->form->getState()['id_buku']);

        if ($jumlahPinjam > $buku->jumlah_asli) { // ✅ Perbaiki disini
            Notification::make()
                ->title('Stok buku tidak mencukupi')
                ->danger()
                ->send();

            $this->halt(); // Hentikan simpan
        }
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $buku = $record->buku; // relasi harus benar di model
        $jumlahPinjam = $record->jumlah_pinjam;

        if ($buku && $jumlahPinjam) {
            $buku->jumlah_asli -= $jumlahPinjam;
            $buku->save();
        }
    }
}
