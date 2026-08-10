<?php

namespace App\Filament\Resources\Criteria;

use App\Filament\Resources\Criteria\Pages\CreateCriterion;
use App\Filament\Resources\Criteria\Pages\EditCriterion;
use App\Filament\Resources\Criteria\Pages\ListCriteria;
use App\Filament\Resources\Criteria\Schemas\CriterionForm;
use App\Filament\Resources\Criteria\Tables\CriteriaTable;
use App\Models\Criterion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CriterionResource extends Resource
{
    protected static ?string $model = Criterion::class;
    //muestra los nombre en espanol
    protected static ?string $navigationLabel   = 'Criterios';
    protected static ?string $modelLabel        = 'Criterio';
    protected static ?string $pluralModelLabel  = 'Criterios';
    protected static ?int    $navigationSort    = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    public static function getNavigationGroup(): ?string
    {
        return 'Académico';
    } //grupo evaluacion

    public static function form(Schema $schema): Schema
    {
        return CriterionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CriteriaTable::configure($table);
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
            'index' => ListCriteria::route('/'),
            'create' => CreateCriterion::route('/create'),
            'edit' => EditCriterion::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->orderBy('rubric_id')->orderBy('order');
    }
}
