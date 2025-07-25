<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamResource\Pages;
use App\Models\Anggota;
use App\Models\buku;
use App\Models\Peminjam;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class PeminjamResource extends Resource
{
    protected static ?string $model = Peminjam::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Peminjam';
    protected static ?string $pluralLabel = 'Peminjam';
    protected static ?string $modelLabel = 'Peminjam';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                Forms\Components\Select::make('id_anggota')
                    ->label('Nama Anggota')
                    ->options(Anggota::query()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('id_buku')
                    ->label('Judul Buku')
                    ->options(function () {
                        return buku::all()->mapWithKeys(function ($buku) {
                            return [
                                $buku->id => "{$buku->judul} ({$buku->jumlah_asli})",
                            ];
                        });
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('jumlah_pinjam')
                    ->numeric()
                    ->minValue(fn (callable $get) => $get('status') ? 1 : 0)
                    ->required()
                    ->label('Jumlah Pinjam')
                    ->reactive()
                    ->disabled(fn (callable $get) => !$get('status'))
                    ->dehydrated(),

                Forms\Components\DatePicker::make('batas_pengembalian')
                    ->required()
                    ->label('Batas Pengembalian'),

                Forms\Components\Select::make('jaminan')
                    ->label('Jaminan')
                    ->options([
                        'KTP' => 'KTP',
                        'KTM' => 'KTM',
                        'SIM' => 'SIM',
                    ])
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('Status Pinjam')
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (!$state) {
                            $set('jumlah_pinjam', 0);
                        }
                    }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('anggota.nama')
                    ->label('Nama Anggota')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('buku.judul')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah_pinjam')
                    ->label('Jumlah Pinjam')
                    ->formatStateUsing(fn ($state) => $state === 0 ? '0' : $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('batas_pengembalian')
                    ->label('Batas Pengembalian')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jaminan')
                    ->label('Jaminan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pinjam')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state ? 'Dipinjam' : 'Dikembalikan'),
            ])
            ->filters([
                Tables\Filters\Filter::make('jatuh_tempo_hari_ini')
                    ->label('Jatuh Tempo Hari Ini')
                    ->query(fn ($query) => $query->whereDate('batas_pengembalian', now()->toDateString())),

                Tables\Filters\Filter::make('telat')
                    ->label('Sudah Lewat Batas')
                    ->query(fn ($query) => $query->whereDate('batas_pengembalian', '<', now()->toDateString())),

                Tables\Filters\Filter::make('akan_jatuh_tempo')
                    ->label('Akan Jatuh Tempo (< 3 hari)')
                    ->query(fn ($query) => $query->whereBetween('batas_pengembalian', [now(), now()->addDays(3)])),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function ($records) {
                        foreach ($records as $record) {
                            $buku = buku::find($record->id_buku);
                            if ($buku) {
                                $buku->jumlah_asli += $record->jumlah_pinjam;
                                $buku->save();
                            }
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjams::route('/'),
            'create' => Pages\CreatePeminjam::route('/create'),
            'edit' => Pages\EditPeminjam::route('/{record}/edit'),
        ];
    }

        public static function getNavigationSort(): ?int
    {
        return 5; // Ubah sesuai urutan yang kamu mau
    }
}
