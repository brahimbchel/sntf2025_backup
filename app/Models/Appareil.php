<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appareil
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Rubrique[] $rubriques
 *
 * @package App\Models
 */
class Appareil extends Model
{
	protected $table = 'appareil';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function rubriques()
	{
		return $this->hasMany(Rubrique::class, 'App_id');
	}
}
