<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DGvai\Review\Reviewable;
use Laravel\Scout\Searchable;

class Package extends Model
{
    use HasFactory;
    use Reviewable;
    use Searchable;

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

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
            'sender_adres' => $this->sender_adres,
            'sender_city' => $this->sender_city,
            'sender_postalcode' => $this->sender_postalcode,
            'receiver_name' => $this->receiver_name,
            'receiver_adres' => $this->receiver_adres,
            'receiver_city' => $this->receiver_city,
            'receiver_postalcode' => $this->receiver_postalcode,
        ];
    }
}
