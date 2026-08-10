<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(), //buscador
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),  //buscador
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(), //ordenar arriba abajo
                TextColumn::make('created_at')
                    ->dateTime(),
                   // ->toggleable(isToggledHiddenByDefault: true), para ocultar
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(), //boton editar
                DeleteAction::make(), //boton borrar
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
