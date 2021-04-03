<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
    ];

    public $timestamps = false;


    

}
