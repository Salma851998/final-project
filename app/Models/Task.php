<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Authenticatable
{
    use HasFactory;


    protected $table = "tasks";
    protected $fillable = ['title','content','startDate','endDate','image','userId'];

     public $timestamps = false;


}
