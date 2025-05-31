<x-filament::page>
    <div class="w-full max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nom -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Nom</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->nom }}
                </div>
            </div>

            <!-- Prénom -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Prénom</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->prenom }}
                </div>
            </div>

            <!-- Matricule -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Matricule</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->matricule }}
                </div>
            </div>

            <!-- Fonction -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Fonction</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->fonction }}
                </div>
            </div>

            <!-- Département -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Département</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->departement->nom ?? 'N/A' }}
                </div>
            </div>

            <!-- Date de naissance -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Date de naissance</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->datedenaissance ? \Carbon\Carbon::parse($employe->datedenaissance)->format('d/m/Y') : 'N/A' }}
                </div>
            </div>

            <!-- Genre -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Genre</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->gender }}
                </div>
            </div>

            <!-- Adresse -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Adresse</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->adresse ?? 'N/A' }}
                </div>
            </div>

            <!-- Téléphone -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Téléphone</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->tel }}
                </div>
            </div>

            <!-- E-mail (user) -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">E-mail</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->user->email }}
                </div>
            </div>

            <!-- Groupe sanguin -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Groupe sanguin</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-red-600 dark:text-red-300 font-semibold rounded-md px-4 py-2">
                    {{ $employe->groupe_sanguin ?? 'N/A' }}
                </div>
            </div>

            <!-- Situation familiale -->
            <div class="flex flex-col items-center text-center space-y-1">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">Situation familiale</span>
                <div class="w-full border border-primary-500 dark:border-primary-400 text-gray-900 dark:text-white font-semibold rounded-md px-4 py-2">
                    {{ $employe->situation_familiale ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</x-filament::page>
