<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Password;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Navigation\Navigation;
use Filament\Navigation\NavigationItem;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model; // Import Model

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()  // Menjadikan field ini menjadi tipe password
                    ->required(),
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                    ])
                    ->default('user')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                BadgeColumn::make('roles')
                    ->getStateUsing(function (User $record) {
                        return implode(', ', $record->getRoleNames()->toArray());
                    })
                    ->colors(['primary']),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationItems(): array
    {
        $items = [];

        // Check if the user has permission to view users using Spatie's 'can' method
        if (auth()->user()->can('view_users')) {
            $items[] = NavigationItem::make()
                ->label('Users')
                ->url(route('filament.admin.resources.users.index')) // Correct route name
                ->icon('heroicon-o-user');
        }

        // Check if the user has permission to view data pajak using Spatie's 'can' method
        

        return $items;
    }

    // Perbaiki method canView untuk menerima parameter $record
    public static function canView(Model $record): bool
    {
        // Pastikan user memiliki permission 'view_users'
        return auth()->user()->can('view_users');
    }

    // Perbaiki method canCreate untuk tidak menerima parameter $record
    public static function canCreate(): bool
    {
        // Hanya user dengan permission 'view_users' yang bisa membuat user baru
        return auth()->user()->can('view_users');
    }
}
