<?php

namespace App\Filament\Resources\StudentAssignments\Pages;

use App\Filament\Resources\StudentAssignments\StudentAssignmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentAssignment extends CreateRecord
{
    protected static string $resource = StudentAssignmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    } //volver
}
