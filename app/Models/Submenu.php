<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'submenu';
    protected $primaryKey = 'id_submenu';
    protected $fillable = [
        'menu_id', 'menu_utama_id' ,'nama_submenu', 'url_submenu', 'ikon_submenu', 'status_submenu'
    ];

    

}
