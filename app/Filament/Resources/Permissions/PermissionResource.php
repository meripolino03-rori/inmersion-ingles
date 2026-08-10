<?php

namespace App\Filament\Resources\Permissions;

use App\Filament\Resources\Permissions\Pages\CreatePermission;
use App\Filament\Resources\Permissions\Pages\EditPermission;
use App\Filament\Resources\Permissions\Pages\ListPermissions;
use App\Filament\Resources\Permissions\Schemas\PermissionForm;
use App\Filament\Resources\Permissions\Tables\PermissionsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

use App\Models\Permission;


class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
        //muestra los nombre en espanol
    protected static ?string $navigationLabel   = 'Permisos';
    protected static ?string $modelLabel        = 'Permiso';
    protected static ?string $pluralModelLabel  = 'Permisos';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey; //icono permiso
    protected static ?int $navigationSort = 3; //prioridad de orden
    protected static string | UnitEnum | null $navigationGroup = 'Configuración'; //navegar por grupo


    public static function form(Schema $schema): Schema
    {
        return PermissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermissionsTable::configure($table);
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
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }
}
