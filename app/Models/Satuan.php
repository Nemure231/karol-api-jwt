<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'satuan';
    protected $primaryKey = 'id_satuan';
    protected $fillable = [
        'nama_satuan',
    ];

    

}
