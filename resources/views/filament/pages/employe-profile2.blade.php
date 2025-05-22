<x-filament::page>
    <div class="max-w-4xl bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Main content with perfect vertical rhythm -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-5">
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Nom</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->nom }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Prénom</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->prenom }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Matricule</span>
                        <span class="text-gray-900 font-semibold bg-blue-50 px-2 py-1 rounded-md">{{ $employe->matricule }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Fonction</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->fonction }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Département</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->departement->nom ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-5">
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Date de naissance</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->date_naissance ? \Carbon\Carbon::parse($employe->date_naissance)->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Gender</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->gender }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Adresse</span>
                        <span class="text-gray-900 font-semibold text-right max-w-[200px]">{{ $employe->adresse ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Téléphone</span>
                        <a href="tel:{{ $employe->tel }}" class="text-blue-600 font-semibold hover:underline">{{ $employe->tel }}</a>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">E-mail</span>
                        <a href="mailto:{{ $employe->email }}" class="text-blue-600 font-semibold hover:underline break-all">{{ $employe->email }}</a>
                    </div>
                </div>
            </div>

            <!-- Bottom section with subtle separation -->
            <div class="mt-8 pt-8 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Groupe sanguin</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                              {{ $employe->groupe_sanguin ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $employe->groupe_sanguin ?: 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-gray-500 font-medium transition-colors duration-200 group-hover:text-blue-600">Situation familiale</span>
                        <span class="text-gray-900 font-semibold">{{ $employe->situation_familiale ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>