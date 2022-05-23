<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'sigles', 'cicles_id', 'actiu'];
    protected $table = 'cursos';
    public $timestamps = false;

    public function cicles()
    {
        return $this->belongsTo(Cicles::class, 'cicles_id');
    }

    /**
     * The roles that belong to the Cursos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function moduls()
    {
        return $this->belongsToMany(Moduls::class, 'moduls_has_cursos', 'cursos_id', 'moduls_id')->withPivot('curs_academic_id');
    }

}
