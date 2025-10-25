<?php

namespace App\Filament\Admin\Resources\Todos\Pages;

use App\Filament\Admin\Resources\Todos\TodoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTodo extends EditRecord
{
    protected static string $resource = TodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
