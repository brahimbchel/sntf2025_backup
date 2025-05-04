<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CentreMedical
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $adresse
 * @property string|null $telephone
 * 
 * @property Collection|Medecin[] $medecins
 *
 * @package App\Models
 */
class CentreMedical extends Model
{
	protected $table = 'centre_medical';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'adresse',
		'telephone'
	];

	public function medecins()
	{
		return $this->hasMany(Medecin::class, 'cm');
	}
}
