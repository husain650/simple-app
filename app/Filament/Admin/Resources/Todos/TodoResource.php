<?php

namespace App\Filament\Admin\Resources\Todos;

use App\Filament\Admin\Resources\Todos\Pages\CreateTodo;
use App\Filament\Admin\Resources\Todos\Pages\EditTodo;
use App\Filament\Admin\Resources\Todos\Pages\ListTodos;
use App\Models\Todo;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|UnitEnum|null $navigationGroup = 'Todo Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Todo';
    protected static ?string $navigationLabel = 'Todos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('due_date')
                    ->native(false)
                    ->displayFormat('M d, Y')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_completed')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Todo $record) => $record->description ? \Illuminate\Support\Str::limit($record->description, 50) : null),

                Tables\Columns\IconColumn::make('is_completed')
                    ->boolean()
                    ->sortable()
                    ->action(
                        fn (Todo $record) => $record->update([
                            'is_completed' => !$record->is_completed
                        ])
                    ),

                Tables\Columns\TextColumn::make('due_date')
                    ->date('M d, Y')
                    ->sortable()
                    ->color(fn (Todo $record) => $record->due_date?->isPast() ? 'danger' : 'success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_completed')
                    ->options([
                        '1' => 'Completed',
                        '0' => 'Incomplete',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('due_date')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_completed')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->modalWidth('md')
                    ->slideOver()
                    ->iconButton(),
                Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('due_date')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->columnSpanFull(),
                    ])
                    ->modalWidth('md')
                    ->slideOver(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTodos::route('/'),
            // We're removing the create and edit routes since we'll use modals
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}