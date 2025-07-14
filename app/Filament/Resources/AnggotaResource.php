<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Models\Anggota;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Anggota';       // ini untuk label di sidebar
    protected static ?string $pluralLabel = 'Anggota';           // ini untuk judul halaman
    protected static ?string $modelLabel = 'Anggota';            // ini untuk label tunggal seperti "Buat Anggota"
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                    ->options([
                        'laki-laki' => 'laki-laki',
                        'perempuan' => 'perempuan',
                    ])
                        ->required(),

                    Forms\Components\Select::make('kelas')
                        ->label('Kelas')
                        ->required()
                        ->options([
                            'VII' => 'VII',
                            'VIII' => 'VIII',
                            'IX' => 'IX',
                            'X' => 'X',
                            'XI' => 'XI',
                            'XII' => 'XII',
                            'kuliah' => 'kuliah',
                            'lainnya' => 'Lainnya',
                        ]),

                    Forms\Components\TextInput::make('program_studi')
                        ->label('Program Studi')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('no_hp')
                        ->label('No Hp')
                        ->required()
                        ->maxLength(255),
                    
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                ->label('No')
        ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_studi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}
