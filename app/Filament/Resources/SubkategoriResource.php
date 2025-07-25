<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubkategoriResource\Pages;
use App\Models\Subkategori;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubkategoriResource extends Resource
{
    protected static ?string $model = Subkategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Sub Kategori';
    protected static ?string $pluralLabel = 'Subkategori';
    protected static ?string $modelLabel = 'Subkategori';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama')
                    // ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama Subkategori')
                    ->required()
                    ->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Subkategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diperbarui')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Kalau mau filter nanti bisa ditambah
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Kalau nanti mau tambah RelationManager ke Buku, bisa di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubkategoris::route('/'),
            'create' => Pages\CreateSubkategori::route('/create'),
            'edit' => Pages\EditSubkategori::route('/{record}/edit'),
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 3; // Ubah sesuai urutan sidebar
    }
}
