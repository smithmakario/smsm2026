@extends('emails.layout')

@section('content')
<!-- Hero Section -->
<tr>
    <td style="padding: 32px 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #308ce8; background: linear-gradient(135deg, #308ce8 0%, #1d6fc4 100%); border-radius: 8px;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0; font-size: 28px; font-weight: 800; color: #ffffff; line-height: 1.2;">New assignment</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- Page Heading -->
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0 0 8px; font-size: 24px; font-weight: 800; color: #1e293b; line-height: 1.2;">Hi {{ $coordinator->full_name }},</p>
        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.6;">You've been assigned as coordinator for the cohort <strong>{{ $cohort->name }}</strong>.</p>
    </td>
</tr>
<!-- Chips / Quick Info -->
<tr>
    <td style="padding: 0 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0">
            <tr>
                @if($cohort->meeting_time)
                <td style="padding: 8px 12px; background-color: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px;">
                    <p style="margin: 0; font-size: 14px; font-weight: 600; color: #308ce8;">📅 {{ $cohort->meeting_time->format('F j, Y') }}</p>
                </td>
                <td style="width: 12px;"></td>
                @endif
                <td style="padding: 8px 12px; background-color: #f1f5f9; border-radius: 6px;">
                    <p style="margin: 0; font-size: 14px; font-weight: 500; color: #475569;">👥 {{ $cohort->members->count() }} Participants</p>
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
                    <a href="{{ route('coordinator.cohorts.show', $cohort) }}" style="display: inline-block; padding: 16px 32px; background-color: #308ce8; color: #ffffff !important; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 8px;">View cohort & meeting details →</a>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-top: 16px;">
                    <p style="margin: 0; font-size: 12px; color: #94a3b8;">Button not working? Copy and paste this link: <u>{{ route('coordinator.cohorts.show', $cohort) }}</u></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
