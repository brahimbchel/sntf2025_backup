<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            background-color: #f9fafb;
            color: #1a202c;
        }

        h1 {
            text-align: center;
            color: #2b6cb0;
            font-size: 36px;
            margin-bottom: 40px;
        }

        .section {
            margin-bottom: 30px;
        }

        h2 {
            color: #2b6cb0;
            border-bottom: 2px solid #bee3f8;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #2c5282;
        }

        p {
            margin: 6px 0;
        }

        .medicaments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 16px;
        }

        .medicaments-table th {
            background-color: #ebf8ff;
            color: #2b6cb0;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #cbd5e0;
        }

        .medicaments-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .footer {
            margin-top: 50px;
            font-size: 14px;
            text-align: center;
            color: #809eca;
        }

        .signature {
            margin-top: 40px;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 30px;
            background-color: #4299e1;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>

    <button class="print-button" onclick="window.print()">🖨️ Imprimer</button>

    <h1>ORDONNANCE</h1>

    <!-- Informations Employé -->
    <div class="section">
        <h2>Informations de l'employé</h2>
        <p><span class="label">Nom :</span> {{ $ordonnance->consultation->dossier_medical->employe->nom }}</p>
        <p><span class="label">Prénom :</span> {{ $ordonnance->consultation->dossier_medical->employe->prenom }}</p>
        <p><span class="label">Matricule :</span> {{ $ordonnance->consultation->dossier_medical->employe->matricule }}</p>
        <p>
            <span class="label">Date de naissance :</span>
            {{ \Carbon\Carbon::parse($ordonnance->consultation->dossier_medical->employe->datedenaissance)->format('d/m/Y') }}
            ({{ \Carbon\Carbon::parse($ordonnance->consultation->dossier_medical->employe->datedenaissance)->age }} ans)
        </p>
        <p><span class="label">Département :</span> {{ $ordonnance->consultation->dossier_medical->employe->departement->nom }}</p>
        <p><span class="label">Fonction :</span> {{ $ordonnance->consultation->dossier_medical->employe->fonction }}</p>
        <p><span class="label">Date de l'ordonnance :</span>
            {{ \Carbon\Carbon::parse($ordonnance->consultation->date)->format('d/m/Y') }}
        </p>
    </div>

    <!-- Recommandations -->
    <div class="section">
        <h2>Recommandations</h2>
        <p>{{ $ordonnance->recommandations ?? 'Aucune recommandation.' }}</p>
    </div>

    <!-- Médicaments -->
    <div class="section">
        <h2>Médicaments</h2>
        <table class="medicaments-table">
            <thead>
                <tr>
                    <th>Nom du médicament</th>
                    <th>Dosage</th>
                    <th>Durée</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordonnance->ordonnance_medicaments as $om)
                    <tr>
                        <td>{{ $om->medicament->nom ?? 'N/A' }}</td>
                        <td>{{ $om->dosage }}</td>
                        <td>{{ $om->duree }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Signature -->
    <div class="section signature">
        <p><span class="label">Médecin :</span> Dr. {{ $ordonnance->consultation->medecin->nom ?? 'Non renseigné' }} {{ $ordonnance->consultation->medecin->prenom ?? '' }}</p>
        <p><span class="label">Email :</span> {{ $ordonnance->consultation->medecin->user->email ?? 'Non renseigné' }}</p>
    </div>

    <!-- Message de santé -->
    <div class="footer">
        <p>🩺 Prenez soin de votre santé. Consultez votre médecin en cas de doute ou d’effet secondaire.</p>
    </div>

</body>
</html>
