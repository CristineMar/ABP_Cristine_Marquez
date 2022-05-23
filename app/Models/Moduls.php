<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moduls extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'sigles', 'descripcio', 'actiu'];
    protected $table = 'moduls';
    public $timestamps = false;

    public function cursos()
    {
        return $this->belongsToMany(Cursos::class, 'moduls_has_cursos','moduls_id', 'cursos_id')->withPivot('curs_academic_id');
    }

    public function cicle()
     {
         return $this->belongsTo(Cicle::class, 'cicles_id');
     }
}
