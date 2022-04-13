<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Digikraaft\ReviewRating\Traits\HasReviewRating;


class package extends Model
{
    use HasFactory;
    use HasReviewRating;

    protected $table = 'packages';
    protected $id = 'Id';

    protected $fillable = [
        'name',
        'status',
        'sender_adres',
        'sender_city',
        'sender_postalcode',
        'receiver_adres',
        'receiver_city',
        'receiver_postalcode',
    ];
}
