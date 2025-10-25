<?php

namespace App\Filament\Admin\Resources\Transcriptions\Pages;

use App\Filament\Admin\Resources\Transcriptions\TranscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTranscriptions extends ListRecords
{
    protected static string $resource = TranscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
