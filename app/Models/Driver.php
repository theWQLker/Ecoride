<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';  // Make sure this matches your table name
    protected $fillable = ['name', 'email', 'password', 'role'];  // Adjust as needed
}
