<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesRole extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'akses_role';
    protected $primaryKey = 'id_akses_role';
    protected $fillable = [
        'menu_id', 'role_id'
    ];

    

}
