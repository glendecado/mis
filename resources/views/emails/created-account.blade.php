<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Account Is Ready! • [App Name]</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
  </head>
  <body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; line-height: 1.6; color: #334155;">
    <!-- Main Container -->
    <div style="max-width: 600px; margin: 0 auto; padding: 0 20px;">
      <!-- Header with Gradient -->
      <div style="background: linear-gradient(135deg, #3B82F6 0%, #6366F1 100%); padding: 40px 0; text-align: center; border-radius: 8px 8px 0 0;">
        <div style="width: 80px; height: 80px; background-color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="#3B82F6" />
            <path d="M12 16V12M12 8H12.01" stroke="white" stroke-width="2" stroke-linecap="round" />
          </svg>
        </div>
        <h1 style="font-size: 28px; font-weight: 700; color: white; margin: 0 0 8px 0;">Welcome, {{ $user->name }}!</h1>
        <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 16px;">Your account is ready to use</p>
      </div>

      <!-- Content Card -->
      <div style="background: white; padding: 32px; border-radius: 0 0 8px 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.05); margin-bottom: 32px;">
        <h2 style="font-size: 20px; font-weight: 600; color: #1e293b; margin: 0 0 24px 0; position: relative; padding-bottom: 12px;">
          <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: linear-gradient(90deg, #3B82F6 0%, #6366F1 100%); border-radius: 3px;"></span>
          Your Account Details
        </h2>

        <div style="margin-bottom: 32px;">
          <div style="display: flex; align-items: center; padding: 16px; background-color: #f8fafc; border-radius: 6px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background-color: #EFF6FF; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M22 6L12 13L2 6" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
            <div>
              <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Email</div>
              <div style="font-weight: 500; color: #1e293b; font-family: monospace;">{{ $user->email }}</div>
            </div>
          </div>

          <div style="display: flex; align-items: center; padding: 16px; background-color: #f8fafc; border-radius: 6px;">
            <div style="width: 40px; height: 40px; background-color: #EFF6FF; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
            <div>
              <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Password</div>
              <div style="font-weight: 500; color: #1e293b; font-family: monospace;">{{ $user->password }}</div>
            </div>
          </div>
        </div>

        <!-- CTA Button -->
        <a href="https://isatuservice.space" style="display: block; text-align: center; background: linear-gradient(90deg, #3B82F6 0%, #6366F1 100%); color: white; font-weight: 600; padding: 16px; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);">
          Get Started Now
          <span style="margin-left: 8px;">→</span>
        </a>
      </div>

      <!-- Footer -->
      <div style="text-align: center; padding-bottom: 32px;">
        <p style="color: #64748b; font-size: 14px; margin: 0 0 24px 0;">If you didn't request this account, please ignore this email.</p>
        <div style="height: 1px; background-color: #e2e8f0; margin: 24px 0;"></div>
        <p style="color: #94a3b8; font-size: 12px; margin: 0 0 8px 0;">© {{ date('Y') }} All rights reserved.</p>
        <p style="margin: 0;">
 
        </p>
      </div>
    </div>
  </body>
</html>
