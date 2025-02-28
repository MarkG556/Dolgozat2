<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    /** @use HasFactory<\Database\Factories\BarberFactory> */
    use HasFactory;

    protected $fillable = ["barber_name"];
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}
