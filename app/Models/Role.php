<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'nama_role'
    ];

    public $timestamps = false;

   

}
