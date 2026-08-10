<?php

namespace App\Filament\Resources\Criteria\Pages;

use App\Filament\Resources\Criteria\CriterionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCriterion extends CreateRecord
{
    protected static string $resource = CriterionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    } //volver
    
}
