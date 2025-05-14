<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Class DossierMedical
 * 
 * @property int $id
 * @property string $description
 * @property int|null $emp_id
 * 
 * @property Employe|null $employe
 * @property Collection|Consultation[] $consultations
 *
 * @package App\Models
 */
class DossierMedical extends Model
{

	protected $table = 'dossier_medical';
	public $timestamps = false;

	protected $casts = [
		'emp_id' => 'int'
	];

	protected $fillable = [
		'emp_id',
		'activite_professionnelles_anterieures',
        'antecedents_familiaux',
        'antecedents_personnels',
        'maladies_professionnelles',
        'observations'
	];

	public function employe()
	{
		return $this->belongsTo(Employe::class, 'emp_id');
	}

	public function consultations()
	{
		return $this->hasMany(\App\Models\Consultation::class, 'dossier_id');
	}


}
