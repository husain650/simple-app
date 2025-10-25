<?php

namespace App\Filament\Admin\Resources\Todos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TodoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_completed')
                    ->required(),
                DatePicker::make('due_date'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
            ]);
    }
}
