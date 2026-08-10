<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Tables\RolesTable;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use UnitEnum;
use App\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    //muestra los nombre en espanol
    protected static ?string $navigationLabel   = 'Roles';
    protected static ?string $modelLabel        = 'Rol';
    protected static ?string $pluralModelLabel  = 'Roles';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFingerPrint; //icono rol
    protected static ?int $navigationSort = 2; //prioridad de orden
    protected static string | UnitEnum | null $navigationGroup = 'Configuración'; //navegar por grupo

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('name', '!=', 'admin');
    } //para que no sea visible Admin
}
