<x-filament::widget>
    <x-filament::card class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 shadow-xl">
        @php
            $user = auth()->user();
            $name = $user->name ?? 'Utilisateur';
            $role = $user->getRoleNames()->first() ?? 'Invité';
        @endphp

        <div class="text-center space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Bonjour {{ $name }}, bienvenue 👋
            </h2>

            @if ($role === 'admin' || $role === 'Super Admin' || $role === 'admin-agent')
                <p class="text-gray-700 dark:text-gray-300 text-base max-w-2xl mx-auto">
                    Vous êtes connecté en tant qu’administrateur. Vous pouvez gérer les utilisateurs, les dossiers médicaux, les statistiques, et superviser l’ensemble de la plateforme. Utilisez les outils du tableau de bord pour garder le contrôle total sur le système.
                </p>
            @elseif ($role === 'medecin')
                <p class="text-gray-700 dark:text-gray-300 text-base max-w-2xl mx-auto">
                    Vous êtes connecté en tant que médecin. Depuis ce tableau de bord, vous pouvez consulter vos rendez-vous, accéder aux dossiers médicaux de vos patients et suivre vos statistiques de consultation.
                </p>
            @elseif ($role === 'agent' || $role === 'employe')
                <p class="text-gray-700 dark:text-gray-300 text-base max-w-2xl mx-auto">
                    Vous êtes connecté en tant qu’agent de centre médical. Utilisez ce tableau pour organiser les dossiers, planifier les rendez-vous et assister les médecins dans leur travail quotidien.
                </p>
            @else
                <p class="text-gray-700 dark:text-gray-300 text-base max-w-2xl mx-auto">
                    Bienvenue sur la plateforme de gestion médicale. Si vous avez besoin d’assistance ou de formation, veuillez contacter votre administrateur.
                </p>
            @endif

            <p class="text-gray-500 dark:text-gray-400 text-xs">
                Merci d’utiliser notre application. Ensemble, améliorons la gestion des soins médicaux.
            </p>
        </div>
    </x-filament::card>
</x-filament::widget>
