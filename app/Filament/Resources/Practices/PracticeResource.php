<?php

namespace App\Filament\Resources\Practices;

use App\Filament\Resources\Practices\Pages\CreatePractice;
use App\Filament\Resources\Practices\Pages\EditPractice;
use App\Filament\Resources\Practices\Pages\ListPractices;
use App\Filament\Resources\Practices\Schemas\PracticeForm;
use App\Filament\Resources\Practices\Tables\PracticesTable;
use App\Models\Practice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PracticeResource extends Resource
{
    protected static ?string $model = Practice::class;
    //muestra los nombre en espanol
    protected static ?string $navigationLabel   = 'Prácticas externas';
    protected static ?string $modelLabel        = 'Práctica';
    protected static ?string $pluralModelLabel  = 'Prácticas externas';
    protected static ?int    $navigationSort    = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Link;

    public static function getNavigationGroup(): ?string
    {
        return 'Evaluación';
    } //grupo evaluacion

    public static function form(Schema $schema): Schema
    {
        return PracticeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PracticesTable::configure($table);
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
            'index' => ListPractices::route('/'),
            'create' => CreatePractice::route('/create'),
            'edit' => EditPractice::route('/{record}/edit'),
        ];
    }
}
