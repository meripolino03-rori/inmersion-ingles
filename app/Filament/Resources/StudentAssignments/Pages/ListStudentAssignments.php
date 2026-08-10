<?php

namespace App\Filament\Resources\StudentAssignments\Pages;

use App\Filament\Resources\StudentAssignments\StudentAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentAssignments extends ListRecords
{
    protected static string $resource = StudentAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
