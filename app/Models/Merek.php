<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'merek';
    protected $primaryKey = 'id_merek';
    protected $fillable = [
        'nama_merek',
    ];
    
    public $timestamps = false;

    

}
