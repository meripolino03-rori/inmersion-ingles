<?php

namespace App\Filament\Resources\StudentAssignments\Pages;

use App\Filament\Resources\StudentAssignments\StudentAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentAssignment extends EditRecord
{
    protected static string $resource = StudentAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    } //volver
}
