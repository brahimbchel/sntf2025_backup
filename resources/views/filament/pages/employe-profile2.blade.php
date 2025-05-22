<x-filament::page>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Nom Complet: {{ $employe->nom }} {{ $employe->prenom }}</h2>
        <p><strong>Email:</strong> {{ $employe->email }}</p>
        <p><strong>Département:</strong> {{ $employe->departement->nom ?? 'Aucun' }}</p>
        <p><strong>Téléphone:</strong> {{ $employe->telephone }}</p>
        <p><strong>Poste:</strong> {{ $employe->poste }}</p>
        <!-- Add more fields as needed -->
    </div>
</x-filament::page>
