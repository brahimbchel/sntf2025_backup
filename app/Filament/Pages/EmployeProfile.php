<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;

class EmployeProfile extends Page
{
    public static function canViewAny(): bool
{
    return auth()->user()?->isEmploye();
}

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.employe-profile2';

    protected static ?string $navigationLabel = 'Mon Profil';
    protected static ?string $navigationGroup = 'Staff & Users';

    public $employe;

     public function mount()
    {
        $this->employe = Employe::where('user_id', Auth::id())->firstOrFail();
    }

    // protected function getHeading(): string
    // {
    //     return 'Mon Profil Employé';
    // }
}
