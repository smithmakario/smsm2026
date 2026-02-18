@extends('emails.layout')

@section('content')
<!-- Hero Section -->
<tr>
    <td style="padding: 32px 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #308ce8; background: linear-gradient(135deg, #308ce8 0%, #1d6fc4 100%); border-radius: 8px;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0; font-size: 32px; font-weight: 800; color: #ffffff; line-height: 1.2;">We miss you</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- Page Heading -->
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0 0 8px; font-size: 24px; font-weight: 800; color: #1e293b; line-height: 1.2;">{{ $cohort->name }}</p>
        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.6;">Hi {{ $user->first_name }}, we noticed you've missed some sessions. Your cohort and coordinator are here to support you—we'd love to see you back.</p>
    </td>
</tr>
@if($cohort->coordinator)
<!-- Coordinator note -->
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0; font-size: 14px; color: #475569; line-height: 1.6;">Your coordinator {{ $cohort->coordinator->full_name }} is available if you want to reconnect or adjust your schedule.</p>
    </td>
</tr>
@endif
<!-- CTA Button -->
<tr>
    <td style="padding: 0 32px 32px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center">
                    <a href="{{ route('mentee.index') }}" style="display: inline-block; padding: 16px 32px; background-color: #308ce8; color: #ffffff !important; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 8px;">View cohort</a>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-top: 16px;">
                    <p style="margin: 0; font-size: 12px; color: #94a3b8;">Button not working? Copy and paste: <u>{{ route('mentee.index') }}</u></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
