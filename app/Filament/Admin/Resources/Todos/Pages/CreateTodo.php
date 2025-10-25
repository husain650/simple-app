<?php

namespace App\Filament\Admin\Resources\Todos\Pages;

use App\Filament\Admin\Resources\Todos\TodoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTodo extends CreateRecord
{
    protected static string $resource = TodoResource::class;
}
