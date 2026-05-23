<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Property Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #96A480; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">New Property Inquiry</h1>
    </div>
    
    <div style="background-color: #f9f9f9; padding: 20px; margin-top: 20px;">
        <h2 style="color: #96A480; margin-top: 0;">Inquiry Details</h2>
        
        <table style="width: 100%; border-collapse: collapse;">
            @if(!empty($data['inquiry_number']))
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; width: 40%;">Inquiry Number:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['inquiry_number'] }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; width: 40%;">Nama:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;">Email:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;">Nomor WA:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['whatsapp'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;">Inquiry Categories:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['subject'] ?? '-' }}</td>
            </tr>
            @if(!empty($data['property_number']))
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;">Property Number:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $data['property_number'] }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; vertical-align: top;">Note:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ nl2br(e($data['note'])) }}</td>
            </tr>
        </table>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background-color: #e8f4f8; border-left: 4px solid #96A480;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            This inquiry was submitted through the PROSPEDITY website contact form.
        </p>
    </div>
</body>
</html>
