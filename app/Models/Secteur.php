<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Secteur
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Departement[] $departements
 *
 * @package App\Models
 */
class Secteur extends Model
{
	protected $table = 'secteur';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function departements()
	{
		return $this->hasMany(Departement::class);
	}
}
