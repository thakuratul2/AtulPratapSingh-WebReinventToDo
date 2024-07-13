<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListToDo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    protected $table = 'list_to_dos';

}
