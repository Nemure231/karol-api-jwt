<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $fillable = [
        'nama_supplier',
    ];
    public $timestamps = false;

    

}
