<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Models\Buku;
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
        return $form
            ->schema([
                Grid::make(1)->schema([
                    Forms\Components\TextInput::make('judul')->required()->maxLength(255),
                    Forms\Components\TextInput::make('penulis')->required()->maxLength(255),
                    Forms\Components\FileUpload::make('gambar')
                        ->required()
                        ->image()
                        ->disk('public')
                        ->directory('gambar-buku'),
                    Forms\Components\RichEditor::make('sinopsis')->label('Sinopsis')->required(),
                    Forms\Components\Select::make('kategori_id')
                        ->label('Kategori Buku')
                        ->relationship('kategori', 'nama')
                        ->required(),
                    Forms\Components\TextInput::make('jumlah_asli')->required()->numeric(),
                    Forms\Components\TextInput::make('kode_penempatan')->required()->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('penulis')->searchable(),
                Tables\Columns\ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('sinopsis')
                        ->formatStateUsing(fn (string $state): string => strip_tags($state))
                        ->limit(20)
                        ->wrap(),

                Tables\Columns\TextColumn::make('kategori.nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('jumlah_asli')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('kode_penempatan')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
}
