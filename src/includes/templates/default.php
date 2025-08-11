<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0;" />
  <meta name="format-detection" content="telephone=no" />
  <title>{{email_subject}}</title>
  <style>
    body {
      margin: 0; padding: 0; width: 100% !important; height: 100% !important;
      -webkit-font-smoothing: antialiased; text-size-adjust: 100%;
      background-color: #F0F0F0; 
      color: #4B2E2E;
      font-family: Roboto, Arial, "Helvetica Neue", Helvetica, sans-serif;
      line-height: normal;
    }
    table, td { border-collapse: collapse !important; }
    img { border: 0; outline: none; display: block; max-width: 100%; height: auto; }
    a { color: #7B1F1F; text-decoration: none; }
    .btn-table td {
      background-color: #7B1F1F;
      padding: 12px 24px;
      border-radius: 4px;
    }
    .btn-table a {
      color: #FFFFFF;
      font-size: 17px;
    }
    hr {
      border: none;
      border-top: 1px solid #7B1F1F;
      margin: 0;
    }
    h2 {
      color: #4B2E2E;
      margin-top: 0;
    }
    p, td {
      color: #4B2E2E;
      font-size: 17px;
    }
    @media only screen and (max-width: 600px) {
      .container, .wrapper { width: 100% !important; }
      .btn-table {
        max-width: 100% !important;
      }
      .banner-logo img {
        max-width: 140px !important;
        height: auto !important;
      }
      .banner-text a {
        font-size: 20px !important;
      }
    }
  </style>
</head>
<body>
<table width="100%" bgcolor="#F0F0F0" role="presentation">
  <tr>
    <td align="center">
      <table class="wrapper" width="560" style="max-width: 560px;" align="center">
        <tr>
          <td align="center" style="padding: 20px 0;">
            <a href="https://reel-reel.com/">
              <img src="https://reel-reel.com/wp-content/uploads/2021/01/Logo-R-R-on-Bottom-Small.png" width="100" alt="Reel to Reel Logo" />
            </a>
          </td>
        </tr>
      </table>

      <!-- BANNER WITH CENTERED MOTTO -->
      <table class="container" bgcolor="#FFFFFF" width="560" style="max-width: 560px; border-radius: 8px; overflow: hidden;" align="center">
        <tr>
          <td>
            <table width="100%" height="200" cellpadding="0" cellspacing="0" border="0" background="https://reel-reel.com/wp-content/uploads/2016/09/1-1200x480.jpg" style="background-image: url('https://reel-reel.com/wp-content/uploads/2016/09/1-1200x480.jpg'); background-size: cover; background-position: center;">
              <tr>
                <td align="center" valign="middle" height="200" style="background-color: rgba(0,0,0,0.45);">
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                      <td align="center" style="padding: 0 15px;">
                        <span style="display: block; font-weight: 700; font-size: 18px; text-transform: uppercase; letter-spacing: 2px; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7); color: #FFFFFF; font-style: italic; font-family: Georgia, serif;">
                          "THE DIRECTORY OF EVERYTHING - REEL TO REEL"
                        </span>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- MAIN CONTENT -->
        <tr>
          <td style="padding: 25px 6.25%;">
            <h2 style="margin-top: 20px; text-align: center">Welcome to Reel to Reel!</h2>
            {{email_body}}
          </td>
        </tr>

        <!-- CTA BUTTON -->
        <tr>
          <td align="center" style="padding: 10px 6.25% 30px;">
            <table align="center" class="btn-table" style="max-width: 240px; width: 100%;">
              <tr>
                <td align="center">
                  <a href="https://reel-reel.com/">Visit Reel to Reel</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- SEPARATOR -->
        <tr>
          <td style="padding: 0 6.25%;">
            <hr />
          </td>
        </tr>

        <!-- SUPPORT INFO -->
        <tr>
          <td align="center" style="padding: 25px 6.25% 20px; font-size: 16px;">
            Have questions? <a href="mailto:openreel@reel-reel.com" style="color: #7B1F1F;">Email us</a>
          </td>
        </tr>
      </table>

      <!-- FOOTER -->
      <table class="wrapper" width="560" style="max-width: 560px;" align="center">
        <tr>
          <td align="center" style="padding: 25px 6.25%; color: #7B1F1F; font-size: 13px;">
            <table width="256" align="center" style="margin-bottom: 10px;">
              <tr>
                <td style="padding: 0 10px;">
                  <a href="https://facebook.com/reel2reel"><img src="https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/facebook.png" width="44" alt="Facebook" /></a>
                </td>
                <td style="padding: 0 10px;">
                  <a href="https://twitter.com/reel2reel"><img src="https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/twitter.png" width="44" alt="Twitter" /></a>
                </td>
                <td style="padding: 0 10px;">
                  <a href="https://instagram.com/reel2reel"><img src="https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/instagram.png" width="44" alt="Instagram" /></a>
                </td>
                <td style="padding: 0 10px;">
                  <a href="https://youtube.com/reel2reel"><img src="https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/youtube.png" width="44" alt="YouTube" /></a>
                </td>
              </tr>
            </table>
            You received this email because you registered at
            <a href="https://reel-reel.com/" style="color: #7B1F1F;">reel-reel.com</a>.<br />
            © 2025 Reel to Reel. All rights reserved.
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
