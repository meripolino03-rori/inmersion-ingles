<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')
                        ->minLength(2)
                        ->maxLength(255)
                        ->required() //no vacio
                        ->unique(ignoreRecord: true)
                ])
                    ->columnSpanFull() //seccion de form mas grande
                    ->columns(2) //columnas en el formulario
            ]);
    }
}
