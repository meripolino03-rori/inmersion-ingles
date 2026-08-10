<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email') //email addres
                        ->email()
                        ->required(),
                    DateTimePicker::make('email_verified_at'),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn($livewire) => $livewire instanceof CreateRecord)
                        ->maxLength(255),
                    Select::make('roles')
                        ->multiple()
                        ->relationship('roles', titleAttribute: 'name')
                        ->preload(), // carga los permisos ya dados
                    Select::make('permissions')
                        ->multiple()
                        ->relationship('permissions', titleAttribute: 'name')
                        ->preload(), // carga los permisos ya dados

                ])
                    ->columns(2) //columnas en el formulario
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
