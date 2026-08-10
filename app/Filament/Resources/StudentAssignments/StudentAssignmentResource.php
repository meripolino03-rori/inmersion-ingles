<?php

namespace App\Filament\Resources\StudentAssignments;

use App\Filament\Resources\StudentAssignments\Pages\CreateStudentAssignment;
use App\Filament\Resources\StudentAssignments\Pages\EditStudentAssignment;
use App\Filament\Resources\StudentAssignments\Pages\ListStudentAssignments;
use App\Filament\Resources\StudentAssignments\Schemas\StudentAssignmentForm;
use App\Filament\Resources\StudentAssignments\Tables\StudentAssignmentsTable;

use App\Models\StudentAssignment;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentAssignmentResource extends Resource
{
    protected static ?string $model = StudentAssignment::class;

    // nombres en español
    protected static ?string $navigationLabel  = 'Asignación de estudiantes';
    protected static ?string $modelLabel       = 'Asignación de estudiante';
    protected static ?string $pluralModelLabel = 'Asignaciones de estudiantes';

    // orden del menú
    protected static ?int $navigationSort = 7;

    // icono
    protected static string|BackedEnum|null $navigationIcon =
    Heroicon::OutlinedAcademicCap;

    // grupo menú
    public static function getNavigationGroup(): ?string
    {
        return 'Académico';
    }

    public static function form(Schema $schema): Schema
    {
        return StudentAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentAssignmentsTable::configure($table);
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
            'index'  => ListStudentAssignments::route('/'),
            'create' => CreateStudentAssignment::route('/create'),
            'edit'   => EditStudentAssignment::route('/{record}/edit'),
        ];
    }
}
