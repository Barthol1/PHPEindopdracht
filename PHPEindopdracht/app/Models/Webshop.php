<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webshop extends Model
{
    use HasFactory;

    protected $table = 'Webshops';
    protected $id = 'Id';

    protected $fillable = [
        'name',
        'adres',
        'place',
        'postalcode'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }
}
