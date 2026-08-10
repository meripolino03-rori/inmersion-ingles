<?php

namespace App\Filament\Resources\Cycles;

use App\Filament\Resources\Cycles\Pages\CreateCycle;
use App\Filament\Resources\Cycles\Pages\EditCycle;
use App\Filament\Resources\Cycles\Pages\ListCycles;
use App\Filament\Resources\Cycles\Schemas\CycleForm;
use App\Filament\Resources\Cycles\Tables\CyclesTable;
use App\Models\Cycle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CycleResource extends Resource
{
    protected static ?string $model = Cycle::class;
    //muestra los nombre en espanol
    protected static ?string $navigationLabel   = 'Ciclos académicos';
    protected static ?string $modelLabel        = 'Ciclo';
    protected static ?string $pluralModelLabel  = 'Ciclos académicos';
    protected static ?int    $navigationSort    = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Calendar;

    public static function getNavigationGroup(): ?string
    {
        return 'Académico';
    } //grupo academico

    public static function form(Schema $schema): Schema
    {
        return CycleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CyclesTable::configure($table);
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
            'index' => ListCycles::route('/'),
            'create' => CreateCycle::route('/create'),
            'edit' => EditCycle::route('/{record}/edit'),
        ];
    }
}
