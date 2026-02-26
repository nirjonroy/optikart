@php
    $visitLabels = \App\Models\Appointment::visitTypes();
    $visitLabel = $visitLabels[$appointment->visit_type] ?? $appointment->visit_type;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Your Optikart appointment request') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,sans-serif;color:#0A1A2F;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#f4f4f4;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 12px 30px rgba(10,26,47,0.08);">
                    <tr>
                        <td style="background:linear-gradient(180deg,#0A1A2F 0%,#4B2E7F 100%);padding:28px 32px;color:#ffffff;">
                            <h1 style="margin:0;font-size:24px;font-weight:700;letter-spacing:0.5px;">{{ __('Appointment Request Received') }}</h1>
                            <p style="margin:8px 0 0;font-size:14px;opacity:0.85;">{{ __('Thank you for choosing Optikart. Here are your booking details:') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;width:160px;">{{ __('Booking Code') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->booking_code }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Name') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Email') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->email }}</td>
                                </tr>
                                @if ($appointment->phone)
                                    <tr>
                                        <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Phone') }}</td>
                                        <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->phone }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Service') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ optional($appointment->service)->title ?? __('Selected service') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Visit Type') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $visitLabel }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#4b5563;">{{ __('Preferred Slot') }}</td>
                                    <td style="padding:6px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->formatted_slot }}</td>
                                </tr>
                                @if ($appointment->notes)
                                    <tr>
                                        <td style="padding:10px 0;font-size:14px;color:#4b5563;vertical-align:top;">{{ __('Notes') }}</td>
                                        <td style="padding:10px 0;font-size:14px;color:#0A1A2F;font-weight:600;">{{ $appointment->notes }}</td>
                                    </tr>
                                @endif
                            </table>

                            <div style="margin-top:24px;padding:18px 16px;border-radius:10px;background:#f8fafc;color:#334155;font-size:14px;line-height:1.6;">
                                {{ __('Our team will review your request and confirm the final time. If you need immediate assistance, please call our care line or reply to this email.') }}
                            </div>

                            <div style="text-align:center;margin-top:28px;">
                                <a href="{{ url('/') }}"
                                   style="display:inline-block;padding:12px 24px;border-radius:999px;background:#0A1A2F;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;">
                                    {{ __('Visit Optikart') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 32px;background:#0A1A2F;color:#cbd5e1;font-size:12px;text-align:center;">
                            {{ config('mail.from.name', config('app.name')) }} &bull; {{ __('Thank you for trusting us with your eye care.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
