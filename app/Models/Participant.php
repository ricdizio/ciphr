<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    /**
     * table name
     *
     * @var string
     */
     protected $table = 'participants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [ 
        'id',
        'fName',
        'lName',
        'phone',
        'note' ,
        'created_at' ,
        'updated_at' 
    ];

    public $timestamps = true;
    
}
