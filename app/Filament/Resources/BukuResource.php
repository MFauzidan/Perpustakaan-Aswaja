<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Models\Buku;
use App\Models\Subkategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $pluralLabel = 'Buku';
    protected static ?string $modelLabel = 'Buku';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Buku')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('penulis')
                    ->label('Penulis')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar Sampul')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('gambar-buku'),

                Forms\Components\RichEditor::make('sinopsis')
                    ->label('Sinopsis')
                    ->required(),

                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori Buku')
                    ->relationship('kategori', 'nama')
                    ->required()
                    ->reactive() // WAJIB agar Subkategori update otomatis
                    ->afterStateUpdated(fn (callable $set) => $set('subkategori_id', null)),

                Forms\Components\Select::make('subkategori_id')
                    ->label('Subkategori Buku')
                    ->options(function (Forms\Get $get) {
                        $kategoriId = $get('kategori_id');
                        if (!$kategoriId) {
                            return [];
                        }

                        return Subkategori::where('kategori_id', $kategoriId)
                            ->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('jumlah_asli')
                    ->label('Jumlah Asli')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Forms\Components\TextInput::make('penerbit')
                    ->label('Penerbit')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('tahun_terbit')
                    ->label('Tahun Terbit')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('jumlah_halaman')
                    ->label('Jumlah Halaman')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                Forms\Components\TextInput::make('kode_penempatan')
                    ->label('Kode Penempatan')
                    ->required()
                    ->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar'),

                Tables\Columns\TextColumn::make('sinopsis')
                    ->label('Sinopsis')
                    ->formatStateUsing(fn (string $state): string => strip_tags($state))
                    ->limit(20)
                    ->wrap(),

                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subkategori.nama')
                    ->label('Subkategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun Terbit')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_halaman')
                    ->label('Jumlah Halaman')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_asli')
                    ->label('Jumlah Asli')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode_penempatan')
                    ->label('Kode Penempatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records) {
                        foreach ($records as $buku) {
                            if ($buku->gambar) {
                                Storage::disk('public')->delete($buku->gambar);
                            }
                        }
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 4; // Ubah urutan menu di sidebar sesuai keinginan
    }
}
