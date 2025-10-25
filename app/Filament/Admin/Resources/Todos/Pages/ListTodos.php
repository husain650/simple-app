<?php

namespace App\Filament\Admin\Resources\Todos\Pages;

use App\Filament\Admin\Resources\Todos\TodoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTodos extends ListRecords
{
    protected static string $resource = TodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
