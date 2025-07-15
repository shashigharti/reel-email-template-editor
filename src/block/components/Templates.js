const Templates = {
  coreLayout: `
    <div style="max-width:600px; margin:auto; font-family: Arial, sans-serif; color:#333;">
      <div style="background:#ececec; padding:20px; text-align:center;">
        <img src="https://reel-reel.com/wp-content/uploads/2021/01/Logo-R-R-on-Bottom-Small.png" alt="Logo" width="125" height="60" />
      </div>
      <p>Dear {{recipient_name}},</p>
      <p>This is the core email layout for general communication.</p>
      <p>Best regards,</p>
      <p>{{sender_name}}</p>
      <div style="font-size:12px; color:#777; margin-top:30px; text-align:center;">
        <p>© 2025 Your Company – All rights reserved.</p>
        <p>
          <a href="https://your-company.com/privacy-policy" target="_blank" rel="noopener noreferrer" style="color:#0073aa; text-decoration:none;">Privacy Policy</a> |
          <a href="https://your-company.com/terms-of-service" target="_blank" rel="noopener noreferrer" style="color:#0073aa; text-decoration:none;">Terms of Service</a>
        </p>
      </div>
    </div>
  `,

  expressLayout: `
    <div style="max-width:600px; margin:auto; font-family: Arial, sans-serif; color:#333;">
      <div style="background:#ececec; padding:20px; text-align:center;">
        <img src="https://reel-reel.com/wp-content/uploads/2021/01/Logo-R-R-on-Bottom-Small.png" alt="Logo" width="125" height="60" />
      </div>
      <p>Hello {{recipient_name}},</p>
      <p>This is the express email layout for brief and direct communication.</p>
      <p>Kind regards,</p>
      <p>{{sender_name}}</p>
      <div style="font-size:12px; color:#777; margin-top:30px; text-align:center;">
        <p>© 2025 Your Company – All rights reserved.</p>
        <p>
          <a href="https://your-company.com/privacy-policy" target="_blank" rel="noopener noreferrer" style="color:#0073aa; text-decoration:none;">Privacy Policy</a> |
          <a href="https://your-company.com/terms-of-service" target="_blank" rel="noopener noreferrer" style="color:#0073aa; text-decoration:none;">Terms of Service</a>
        </p>
      </div>
    </div>
  `,
};

export const TemplateNames = {
  coreLayout: 'Core Layout',
  expressLayout: 'Express Layout',
};

export default Templates;
