<!DOCTYPE html>
<html>
<head>
    <title>Your Login OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #333333; text-align: center;">Street 160 Restaurant</h2>
        <p style="color: #555555; font-size: 16px;">Hello,</p>
        <p style="color: #555555; font-size: 16px;">You are trying to log in to the Street 160 POS system. Please use the following One-Time Password (OTP) to complete your login:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; padding: 15px 30px; font-size: 32px; font-weight: bold; color: #d4af37; background-color: #fff9e6; border-radius: 8px; border: 2px dashed #d4af37; letter-spacing: 5px;">
                {{ $otp }}
            </span>
        </div>
        
        <p style="color: #888888; font-size: 14px;">This code will expire in 10 minutes. If you did not request this, please ignore this email or contact the administrator.</p>
        
        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
        <p style="color: #aaaaaa; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} Street 160 Family Restaurant. All rights reserved.</p>
    </div>
</body>
</html>
