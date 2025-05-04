<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Medicament
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * 
 * @property Collection|Ordonnance[] $ordonnances
 *
 * @package App\Models
 */
class Medicament extends Model
{
	protected $table = 'medicament';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'description'
	];

	public function ordonnances()
	{
		return $this->belongsToMany(Ordonnance::class, 'ordonnance_medicament')
					->withPivot('id', 'dosage', 'duree');
	}
}
