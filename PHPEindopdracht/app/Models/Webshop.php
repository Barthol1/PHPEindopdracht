<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webshop extends Model
{
    use HasFactory;

    protected $table = 'webshops';
    protected $id = 'id';

    protected $fillable = [
        'name',
        'adres',
        'place',
        'postalcode'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
