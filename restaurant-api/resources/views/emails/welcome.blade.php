<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Street 160</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #333333; text-align: center;">Welcome to Street 160!</h2>
        <p style="color: #555555; font-size: 16px;">Hello {{ $user->name }},</p>
        <p style="color: #555555; font-size: 16px;">An administrator has created a staff account for you on the Street 160 POS system. You can log in using the following credentials:</p>
        
        <div style="margin: 30px 0; padding: 20px; background-color: #f9f9f9; border-left: 4px solid #d4af37;">
            <p style="margin: 0 0 10px 0; font-size: 16px;"><strong>Username:</strong> {{ $user->username }}</p>
            <p style="margin: 0; font-size: 16px;"><strong>Email:</strong> {{ $user->email }}</p>
        </div>
        
        <p style="color: #555555; font-size: 16px;">When you log in, you will also receive a One-Time Password (OTP) to this email address for extra security.</p>
        <p style="color: #888888; font-size: 14px;">If you have any questions, please contact your administrator.</p>
        
        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
        <p style="color: #aaaaaa; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} Street 160 Family Restaurant. All rights reserved.</p>
    </div>
</body>
</html>
