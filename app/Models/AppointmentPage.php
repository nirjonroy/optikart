<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'badge_text',
        'hero_image',
        'info_title',
        'info_description',
        'contact_phone',
        'contact_email',
        'contact_address',
        'working_hours',
        'note',
    ];
}
