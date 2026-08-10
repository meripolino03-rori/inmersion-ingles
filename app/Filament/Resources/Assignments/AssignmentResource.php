<?php

namespace App\Filament\Resources\Assignments;

use App\Filament\Resources\Assignments\Pages\CreateAssignment;
use App\Filament\Resources\Assignments\Pages\EditAssignment;
use App\Filament\Resources\Assignments\Pages\ListAssignments;
use App\Filament\Resources\Assignments\Schemas\AssignmentForm;
use App\Filament\Resources\Assignments\Tables\AssignmentsTable;

use App\Models\Assignment;

use BackedEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    // nombres en español
    protected static ?string $navigationLabel  = 'Asignaciones docentes';
    protected static ?string $modelLabel       = 'Asignación docente';
    protected static ?string $pluralModelLabel = 'Asignaciones docentes';

    // orden en menú
    protected static ?int $navigationSort = 6;

    // icono
    protected static string|BackedEnum|null $navigationIcon =
    Heroicon::OutlinedUserCircle;

    // grupo del menú
    public static function getNavigationGroup(): ?string
    {
        return 'Académico';
    }

    public static function form(Schema $schema): Schema
    {
        return AssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentsTable::configure($table);
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
            'index'  => ListAssignments::route('/'),
            'create' => CreateAssignment::route('/create'),
            'edit'   => EditAssignment::route('/{record}/edit'),
        ];
    }
}
