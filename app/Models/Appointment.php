<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const VISIT_IN_STORE = 'in_store';
    public const VISIT_HOME_SERVICE = 'home_service';

    protected $fillable = [
        'booking_code',
        'name',
        'email',
        'phone',
        'service_id',
        'visit_type',
        'appointment_at',
        'notes',
        'status',
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            if (blank($appointment->booking_code)) {
                $appointment->booking_code = self::generateBookingCode();
            }

            if (blank($appointment->status)) {
                $appointment->status = self::STATUS_PENDING;
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_at', '>=', now());
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_CONFIRMED => __('Confirmed'),
            self::STATUS_COMPLETED => __('Completed'),
            self::STATUS_CANCELLED => __('Cancelled'),
        ];
    }

    public static function visitTypes(): array
    {
        return [
            self::VISIT_IN_STORE => __('In-store consultation'),
            self::VISIT_HOME_SERVICE => __('Home eye check'),
        ];
    }

    public function getFormattedSlotAttribute(): string
    {
        return $this->appointment_at
            ? $this->appointment_at->timezone(config('app.timezone'))->format('d M Y, h:i A')
            : '';
    }

    protected static function generateBookingCode(): string
    {
        $prefix = 'APT-' . now()->format('ymd');

        $latestSequence = self::where('booking_code', 'like', $prefix . '%')
            ->orderByDesc('booking_code')
            ->value('booking_code');

        $number = 1;

        if ($latestSequence && Str::contains($latestSequence, '-')) {
            $parts = explode('-', $latestSequence);
            $number = isset($parts[2]) ? ((int) $parts[2] + 1) : 1;
        }

        return sprintf('%s-%04d', $prefix, $number);
    }
}
