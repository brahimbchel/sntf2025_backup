<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Resultat
 * 
 * @property int $rubrique_id
 * @property int $consultation_id
 * @property string|null $resultat
 * 
 * @property Rubrique $rubrique
 * @property Consultation $consultation
 *
 * @package App\Models
 */
class Resultat extends Model
{
    protected $table = 'resultat';
    public $timestamps = true;
    public $incrementing = false; // pk composite
    protected $primaryKey = ['rubrique_id', 'consultation_id'];


    protected $casts = [
        'rubrique_id' => 'int',
        'consultation_id' => 'int',
    ];

    protected $fillable = [
        'resultat',
        'rubrique_id',
        'consultation_id',
    ];

    public function rubrique()
    {
        return $this->belongsTo(Rubrique::class, 'rubrique_id'); // Relation correcte avec Rubrique
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id'); // Relation correcte avec Consultation
    }
}