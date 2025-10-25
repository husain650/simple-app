<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                    
                Select::make('role')
                    ->options(User::ROLES)
                    ->default('user')
                    ->required()
                    ->columnSpanFull(),
                    
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->minLength(8)
                    ->same('password_confirmation')
                    ->columnSpanFull(),
                    
                TextInput::make('password_confirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(false)
                    ->columnSpanFull(),
                    
                DateTimePicker::make('email_verified_at')
                    ->default(now())
                    ->displayFormat('M d, Y H:i')
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }
}
