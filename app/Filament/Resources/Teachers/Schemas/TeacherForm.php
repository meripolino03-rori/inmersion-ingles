<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del docente')
                    ->schema([

                        Select::make('user_id')
                            ->label('Docente')
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn($query) =>
                                $query->role('teacher')
                            )
                            ->searchable()
                            ->preload()
                            ->unique(
                                table: 'teachers',
                                column: 'user_id',
                                ignoreRecord: true
                            )
                            ->validationMessages([
                                'unique' => 'Este usuario ya tiene un perfil docente registrado.',
                            ])
                            ->required(),

                        Select::make('school_id')
                            ->label('Escuela')
                            ->relationship('school', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
