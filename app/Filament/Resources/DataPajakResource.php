<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPajakResource\Pages;
use App\Filament\Resources\DataPajakResource\RelationManagers;
use App\Models\DataPajak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataPajakResource extends Resource
{
    protected static ?string $model = DataPajak::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Form Schema
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('nob')
                        ->label('NOB')
                        ->required()
                        ->numeric()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('address_wajib_pajak')
                        ->label('Alamat Wajib Pajak')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('address_objek_pajak')
                        ->label('Alamat Objek Pajak')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('jumlah')
                        ->label('Luas Objek')
                        ->required()
                        ->maxLength(255),
                ])
            ]);
    }

    // Table Schema
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('nob')->label('NOB')->searchable(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('address_wajib_pajak')->label('Alamat WP')->searchable()->limit(30),
                TextColumn::make('address_objek_pajak')->label('Alamat OP')->searchable()->limit(30),
                TextColumn::make('jumlah')->label('Jumlah')->sortable(),
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
                TextColumn::make('updated_at')->label('Update Terakhir')->since(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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

    // Define Relationships if needed
    public static function getRelations(): array
    {
        return [
            // Tambahkan relations jika diperlukan
        ];
    }

    // Define Pages
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPajaks::route('/'),
            'create' => Pages\CreateDataPajak::route('/create'),
            'edit' => Pages\EditDataPajak::route('/{record}/edit'),
        ];
    }
}
