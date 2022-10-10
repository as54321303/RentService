<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'machine_category','model','city','manufactured_year','serial_no','reg_no','fuel_type','owner_id','invoice'
    ];
}
