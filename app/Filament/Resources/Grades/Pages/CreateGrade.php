<?php
namespace App\Filament\Resources\Grades\Pages;

use App\Filament\Resources\Grades\GradeResource;
use App\Models\Grade;
use Filament\Resources\Pages\CreateRecord;

class CreateGrade extends CreateRecord
{
    protected static string $resource = GradeResource::class;

    protected function handleRecordCreation(array $data): Grade
    {
        $scores = $data['scores'] ?? [];
        $total  = round(
            collect($scores)->filter()->sum(fn ($v) => (float) $v),
            2
        );

        return Grade::updateOrCreate(
            [
                'evaluation_id' => $data['evaluation_id'],
                'student_id'    => $data['student_id'],
            ],
            [
                'scores'   => $scores,
                'total'    => $total,
                'feedback' => $data['feedback'] ?? null,
            ]
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}