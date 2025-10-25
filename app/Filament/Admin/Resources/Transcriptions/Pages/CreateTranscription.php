<?php

namespace App\Filament\Admin\Resources\Transcriptions\Pages;

use App\Filament\Admin\Resources\Transcriptions\TranscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTranscription extends CreateRecord
{
    protected static string $resource = TranscriptionResource::class;
}
