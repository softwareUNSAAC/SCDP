<?php

class Campeonato extends Eloquent
{
    protected $table = 'tcampeonato';
    public $timestamps= false;
    protected $primaryKey = 'codCampeonato';
    protected $fillable = ['codCampeonato','nombre','anioAcademico','fechaCreacion','reglamento','habilitar','codCom_Org'];

}