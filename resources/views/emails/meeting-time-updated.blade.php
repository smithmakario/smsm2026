@extends('emails.layout')

@section('content')
<!-- Hero Section -->
<tr>
    <td style="padding: 32px 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #308ce8; background: linear-gradient(135deg, #308ce8 0%, #1d6fc4 100%); border-radius: 8px;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0; font-size: 28px; font-weight: 800; color: #ffffff; line-height: 1.2;">Meeting updated</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- Page Heading -->
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0 0 8px; font-size: 24px; font-weight: 800; color: #1e293b; line-height: 1.2;">{{ $cohort->name }}</p>
        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.6;">The meeting time or link for this cohort has been updated. See details below.</p>
    </td>
</tr>
<!-- Meeting details -->
<tr>
    <td style="padding: 0 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0f9ff; border-left: 4px solid #308ce8; border-radius: 0 8px 8px 0;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0 0 12px; font-size: 16px; font-weight: 700; color: #1e293b;">📅 Meeting details</p>
                    @if($cohort->meeting_time)
                    <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">When:</strong> {{ $cohort->meeting_time->format('l, F j, Y \a\t g:i A') }}</p>
                    @endif
                    @if($cohort->meeting_link)
                    <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">Link:</strong> <a href="{{ $cohort->meeting_link }}" style="color: #308ce8; word-break: break-all;">{{ $cohort->meeting_link }}</a></p>
                    @endif
                    @if(!$cohort->meeting_time && !$cohort->meeting_link)
                    <p style="margin: 0; font-size: 14px; color: #64748b; line-height: 1.6;">Details will be shared soon. Check your dashboard for updates.</p>
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- CTA Button -->
<tr>
    <td style="padding: 0 32px 32px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center">
                    @if($isCoordinator)
                    <a href="{{ route('coordinator.cohorts.show', $cohort) }}" style="display: inline-block; padding: 16px 32px; background-color: #308ce8; color: #ffffff !important; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 8px;">View cohort →</a>
                    @else
                    <a href="{{ route('mentee.index') }}" style="display: inline-block; padding: 16px 32px; background-color: #308ce8; color: #ffffff !important; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 8px;">View dashboard →</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-top: 16px;">
                    <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                        Button not working? Copy and paste: <u>@if($isCoordinator){{ route('coordinator.cohorts.show', $cohort) }}@else{{ route('mentee.index') }}@endif</u>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
