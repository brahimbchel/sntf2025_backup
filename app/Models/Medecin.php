<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Medecin
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property bool|null $gender
 * @property string|null $tel
 * @property string|null $email
 * @property int|null $cm
 * @property int|null $specialite
 * 
 * @property CentreMedical|null $centre_medical
 * @property Collection|Consultation[] $consultations
 *
 * @package App\Models
 */
class Medecin extends Model
{
	protected $table = 'medecin';
	public $timestamps = false;

	protected $casts = [
		'cm' => 'int',
		'specialite_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'gender',
		'tel',
		'email',
		'cm',
		'specialite_id'
	];

	public function specialite()
	{
		return $this->belongsTo(Specialite::class,'specialite_id');
	}

	public function centre_medical()
	{
		return $this->belongsTo(CentreMedical::class, 'cm');
	}

	public function consultations()
	{
		return $this->hasMany(Consultation::class);
	}
}
