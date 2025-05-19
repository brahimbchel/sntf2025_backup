<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employe
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string|null $fonction
 * @property int|null $departement_id
 * @property Carbon|null $datedenaissance
 * @property bool|null $gender
 * @property string|null $adresse
 * @property string|null $tel
 * @property string|null $email
 * @property bool|null $etat
 * 
 * @property Departement|null $departement
 * @property Collection|DossierMedical[] $dossier_medicals
 *
 * @package App\Models
 */
class Employe extends Model
{
	protected $table = 'employe';
	public $timestamps = false;

	protected $casts = [
		'departement_id' => 'int',
		'datedenaissance' => 'datetime'
		];

		protected $fillable = [
		'nom',
		'prenom',
		'matricule',
		'fonction',
		'departement_id',
		'datedenaissance',
		'gender',
		'adresse',
		'tel',
		'email',
		'etat',
		'groupe_sanguin',
		'situation_familiale',
		'service_national',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function departement()
	{
		return $this->belongsTo(Departement::class);
	}

	public function dossier_medicals()
	{
		return $this->hasOne(DossierMedical::class, 'emp_id');

	}
	
	 /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically create a DossierMedical when an Employe is created
        static::created(function ($employe) {
            DossierMedical::create([               
                'emp_id' => $employe->id,
            ]);
        });
    }
}
