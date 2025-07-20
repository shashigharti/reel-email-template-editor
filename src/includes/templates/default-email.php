<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{email_subject}}</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
        color: #333333;
      }
      .email {
        width: 100%;
        background-color: #f4f4f4;
        padding: 20px 0;
      }
      .email__container {
        width: 600px;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        margin: 0 auto;
      }
      .email__body {
        padding: 30px;
        font-size: 16px;
        line-height: 1.5;
      }

      .email__body table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }
      .email__body th,
      .email__body td {
        border: 1px solid #ddd;
        padding: 8px 12px;
        text-align: left;
      }
      .email__body th {
        background-color: #f0f0f0;
        font-weight: bold;
      }
      .email__body tr:nth-child(even) {
        background-color: #fafafa;
      }
    </style>
  </head>
  <body>
    <table cellpadding="0" cellspacing="0" border="0" class="email">
      <tr>
        <td align="center">
          <table cellpadding="0" cellspacing="0" border="0" class="email__container">
            <tr>
              <td class="email__body">
                {{email_body}}
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
