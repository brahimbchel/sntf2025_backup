<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Specialite
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Medecin[] $medecins
 *
 * @package App\Models
 */
class Specialite extends Model
{
	protected $table = 'specialite';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function medecins()
	{
		return $this->hasMany(Medecin::class, 'specialite');
	}
}
