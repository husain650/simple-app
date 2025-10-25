<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Facades\FilamentView;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'user' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => User::ROLES[$state] ?? $state)
                    ->sortable(),
                    
                IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                    
                TextColumn::make('todos_count')
                    ->label('Todos')
                    ->counts('todos')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(User::ROLES),
                    
                Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Verified only'),
            ])
            ->actions([
                Actions\Action::make('impersonate')
                    ->icon('heroicon-o-eye')
                    ->url(fn (User $record): string => route('filament.admin.pages.dashboard', ['impersonate' => $record->id]))
                    ->hidden(fn () => ! auth()->user()->isAdmin())
                    ->openUrlInNewTab(),
                    
                Actions\EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Actions\DeleteAction::make()
                    ->hidden(fn () => ! auth()->user()->isAdmin()),
                
                Actions\Action::make('markVerified')
                    ->icon('heroicon-o-shield-check')
                    ->action(function (\Illuminate\Support\Collection $records) {
                        $records->each->update(['email_verified_at' => now()]);
                    })
                    ->requiresConfirmation()
                    ->hidden(fn () => ! auth()->user()->isAdmin())
                    ->bulk(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
