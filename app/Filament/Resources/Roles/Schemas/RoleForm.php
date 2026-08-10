<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\Select;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')
                        ->minLength(2)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Select::make('permissions')
                        ->multiple()
                        ->relationship('permissions', titleAttribute: 'name')
                        ->preload(), // carga los permisos ya dados
                ])
                    ->columnSpanFull() //seccion de form mas grande
                    ->columns(2) //columnas en el formulario
            ]);
    }
}
