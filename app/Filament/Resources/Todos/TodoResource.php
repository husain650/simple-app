<?php

namespace App\Filament\Resources\Todos;

use App\Filament\Resources\Todos\Pages\CreateTodo;
use App\Filament\Resources\Todos\Pages\EditTodo;
use App\Filament\Resources\Todos\Pages\ListTodos;
use App\Models\Todo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use BackedEnum;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;

    // match Filament\Resource property types
    protected static UnitEnum|string|null $navigationGroup = 'Tasks';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $modelLabel = 'Todo';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),

            DatePicker::make('due_date'),

            Toggle::make('is_completed')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('due_date')->date()->sortable(),
                IconColumn::make('is_completed')->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
            // actions and bulk actions removed to avoid class-not-found on older/newer Filament builds
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTodos::route('/'),
            'create' => CreateTodo::route('/create'),
            'edit' => EditTodo::route('/{record}/edit'),
        ];
    }
}
