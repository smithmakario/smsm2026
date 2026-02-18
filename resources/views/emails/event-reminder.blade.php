@extends('emails.layout')

@section('content')
<tr>
    <td style="padding: 32px 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #308ce8; background: linear-gradient(135deg, #308ce8 0%, #1d6fc4 100%); border-radius: 8px;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0; font-size: 28px; font-weight: 800; color: #ffffff; line-height: 1.2;">Event reminder</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0 0 8px; font-size: 24px; font-weight: 800; color: #1e293b; line-height: 1.2;">{{ $event->title }}</p>
        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.6;">This is a friendly reminder that you're registered for this event. See details below.</p>
    </td>
</tr>
<tr>
    <td style="padding: 0 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0f9ff; border-left: 4px solid #308ce8; border-radius: 0 8px 8px 0;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0 0 12px; font-size: 16px; font-weight: 700; color: #1e293b;">Event details</p>
                    <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">When:</strong> {{ $event->start_at->format('l, F j, Y \a\t g:i A') }}@if($event->end_at) – {{ $event->end_at->format('g:i A') }}@endif</p>
                    <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">Format:</strong> {{ ucfirst($event->format) }}</p>
                    @if($event->format === 'virtual' && $event->meeting_link)
                        <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">Join:</strong> <a href="{{ $event->meeting_link }}" style="color: #308ce8; word-break: break-all;">{{ $event->meeting_link }}</a></p>
                    @elseif($event->location)
                        <p style="margin: 0 0 8px; font-size: 14px; color: #64748b; line-height: 1.6;"><strong style="color: #1e293b;">Where:</strong> {{ $event->location }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding: 0 32px 32px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center">
                    <a href="{{ url('/events/' . $event->id . '/register') }}" style="display: inline-block; padding: 16px 32px; background-color: #308ce8; color: #ffffff !important; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 8px;">View event page</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
