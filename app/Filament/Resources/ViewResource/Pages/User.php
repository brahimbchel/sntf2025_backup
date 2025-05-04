<?php

namespace App\Filament\Resources\ViewResource\Pages;

use App\Filament\Resources\ViewResource;
use Filament\Resources\Pages\Page;

class User extends Page
{
    protected static string $resource = ViewResource::class;

    protected static string $view = 'filament.resources.view-resource.pages.user';
}
