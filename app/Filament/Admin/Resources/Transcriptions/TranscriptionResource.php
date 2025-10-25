<?php

namespace App\Filament\Admin\Resources\Transcriptions;

use App\Filament\Admin\Resources\Transcriptions\Pages\CreateTranscription;
use App\Filament\Admin\Resources\Transcriptions\Pages\EditTranscription;
use App\Filament\Admin\Resources\Transcriptions\Pages\ListTranscriptions;
use App\Filament\Admin\Resources\Transcriptions\Schemas\TranscriptionForm;
use App\Filament\Admin\Resources\Transcriptions\Tables\TranscriptionsTable;
use App\Models\Transcription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TranscriptionResource extends Resource
{
    protected static ?string $model = Transcription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TranscriptionResource.php';

    public static function form(Schema $schema): Schema
    {
        return TranscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TranscriptionsTable::configure($table);
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
            'index' => ListTranscriptions::route('/'),
            'create' => CreateTranscription::route('/create'),
            'edit' => EditTranscription::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
