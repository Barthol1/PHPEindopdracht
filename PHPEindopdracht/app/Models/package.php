<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Digikraaft\ReviewRating\Traits\HasReviewRating;
use Symfony\Component\Mailer\Transport;

class Package extends Model
{
    use HasFactory;
    use HasReviewRating;

    protected $table = 'packages';
    protected $id = 'id';

    protected $fillable = [
        'name',
        'status',
        'sender_adres',
        'sender_city',
        'sender_postalcode',
        'receiver_name',
        'receiver_adres',
        'receiver_city',
        'receiver_postalcode',
        'users_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transporter() {
        return $this->belongsTo(Transporter::class);
    }
}
