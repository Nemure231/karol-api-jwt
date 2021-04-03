<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'nama_menu',
    ];

    public $timestamps = false;


    

}
