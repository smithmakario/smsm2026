@extends('emails.layout')

@section('content')
<tr>
    <td style="padding: 32px 32px 24px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #308ce8; background: linear-gradient(135deg, #308ce8 0%, #1d6fc4 100%); border-radius: 8px;">
            <tr>
                <td style="padding: 24px;">
                    <p style="margin: 0; font-size: 28px; font-weight: 800; color: #ffffff; line-height: 1.2;">Thank you for attending</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding: 0 32px 24px;">
        <p style="margin: 0 0 8px; font-size: 24px; font-weight: 800; color: #1e293b; line-height: 1.2;">{{ $event->title }}</p>
        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.6;">Thank you for being part of this event. We hope you had a great experience.</p>
    </td>
</tr>
<tr>
    <td style="padding: 0 32px 32px;">
        <p style="margin: 0; font-size: 14px; color: #64748b; line-height: 1.6;">If you have any feedback or questions, please don't hesitate to reach out.</p>
    </td>
</tr>
@endsection
