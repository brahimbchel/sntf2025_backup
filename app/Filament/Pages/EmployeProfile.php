<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;

class EmployeProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.employe-profile2';
    protected static ?string $navigationLabel = 'Mon Profil';
    protected static ?string $navigationGroup = 'Staff & Users';

    public $employe;

        public static function canView(): bool
    {
        return auth()->user()?->isEmploye();
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isEmploye();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isEmploye();
    }


     public function mount()
    {
        $this->employe = Employe::where('user_id', Auth::id())->firstOrFail();
    }

    // protected function getHeading(): string
    // {
    //     return 'Mon Profil Employé';
    // }
}
