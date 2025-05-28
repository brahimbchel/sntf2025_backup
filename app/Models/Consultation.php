<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Consultation
 * 
 * @property int $id
 * @property int|null $dossier_id
 * @property int|null $medecin_id
 * @property Carbon|null $date_consultation
 * @property string|null $diagnostic
 * 
 * @property DossierMedical|null $dossier_medical
 * @property Medecin|null $medecin
 * @property Collection|ExplorationComplementaire[] $exploration_complementaires
 * @property Collection|ExplorationFonctionnelle[] $exploration_fonctionnelles
 * @property Collection|Ordonnance[] $ordonnances
 * @property Collection|Resultat[] $resultats
 *
 * @package App\Models
 */
class Consultation extends Model
{
	protected $table = 'consultation';
	public $timestamps = false;

	protected $casts = [
		'dossier_id' => 'int',
		'medecin_id' => 'int',
		'date_consultation' => 'date'
	];

	protected $fillable = [
		'dossier_id',
		'medecin_id',
		'date_consultation',
		'diagnostic',
		'type',
		'aptitude',
		'note'
	];

    protected function mutateFormDataBeforeSave(array $data): array
{
    // Ajoutez un log pour déboguer les données
    \Log::info('Form data before save:', $data);

    // Transformez les tableaux en chaînes si nécessaire
    if (isset($data['rubrique_id']) && is_array($data['rubrique_id'])) {
        $data['rubrique_id'] = implode(',', $data['rubrique_id']);
    }

    return $data;
}

    public function dossier_medical()
    {
        return $this->belongsTo(DossierMedical::class, 'dossier_id');
    }

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    public function exploration_Fonctionnelle()
    {
        return $this->hasMany(ExplorationFonctionnelle::class, 'consultationid');
    }

    public function exploration_Complementaire()
    {
        return $this->hasMany(ExplorationComplementaire::class, 'consultationidC');
    }

    public function appareils()
    {
        return $this->hasMany(Resultat::class, 'consultation_id');
    }


    // public function resultats()
    // {
    //     return $this->hasMany(Resultat::class, 'consultation_id','id');
    // }

    public function interrogatoires_resultats()
    {
        return $this->hasMany(Resultat::class, 'consultation_id', 'id')
            ->whereHas('rubrique', function ($query) {
                $query->where('type', 'interrogatoire');
            });
    }

    public function examens_cliniques_resultats()
    {
        return $this->hasMany(Resultat::class, 'consultation_id', 'id')
            ->whereHas('rubrique', function ($query) {
                $query->where('type', 'examen_clinique');
            });
    }
}
