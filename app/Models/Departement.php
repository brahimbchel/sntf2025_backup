<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Departement
 * 
 * @property int $id
 * @property string $nom
 * @property int|null $secteur_id
 * 
 * @property Secteur|null $secteur
 * @property Collection|Employe[] $employes
 *
 * @package App\Models
 */
class Departement extends Model
{
	protected $table = 'departement';
	public $timestamps = false;

	protected $casts = [
		'secteur_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'secteur_id'
	];

	public function secteur()
	{
		return $this->belongsTo(Secteur::class);
	}

	public function employes()
	{
		return $this->hasMany(Employe::class);
	}
}
