<x-filament::widget>
    <x-filament::card>
        @if ($nextConsultation)
            <div class="text-center">
                <h2 class="text-xl font-bold mb-2">⏰ Prochaine Consultation</h2>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $nextConsultation->date_consultation->format('d/m/Y H:i') }}
                </p>
                <p id="countdown" class="text-2xl mt-4 font-mono text-primary-600"></p>
            </div>

            <script>
                const consultationTime = new Date("{{ $nextConsultation->date_consultation->toIso8601String() }}").getTime();

                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = consultationTime - now;

                    if (distance < 0) {
                        document.getElementById("countdown").innerHTML = "C'est maintenant!";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdown").innerHTML =
                        `${days}j ${hours}h ${minutes}m ${seconds}s`;
                }

                updateCountdown(); // initial call
                setInterval(updateCountdown, 1000); // update every second
            </script>
        @else
            <p class="text-center text-gray-500">Aucune consultation à venir.</p>
        @endif
    </x-filament::card>
</x-filament::widget>
