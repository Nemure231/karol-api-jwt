<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuUtama extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'menu_utama';
    protected $primaryKey = 'id_menu_utama';
    protected $fillable = [
        'menu_id', 'nama_menu_utama', 'ikon_menu_utama'
    ];

    

}
