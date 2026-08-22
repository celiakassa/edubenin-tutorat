<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>@yield('title', 'Kopiao')</title>
<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->
<style>
    body, table, td { font-family: Arial, Helvetica, sans-serif; }
    body { margin: 0; padding: 0; width: 100% !important; background-color: #f7f8fa; }
    img { border: 0; line-height: 100%; outline: none; text-decoration: none; }
    a { text-decoration: none; }
    @media only screen and (max-width: 600px) {
        .kp-email-wrapper { width: 100% !important; }
        .kp-email-padding { padding-left: 20px !important; padding-right: 20px !important; }
    }
</style>
</head>
<body style="margin:0; padding:0; background-color:#f7f8fa;">
<div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#f7f8fa;">
    @yield('preheader', '')
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f7f8fa;">
<tr>
<td align="center" style="padding: 32px 16px;">

    <table role="presentation" class="kp-email-wrapper" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px;">

        <!-- En-tête -->
        <tr>
            <td align="center" style="background-color:#0B69F1; border-radius:14px 14px 0 0; padding: 26px 24px;">
                <a href="{{ url('/') }}" style="text-decoration:none;">
                    <span style="font-family: 'Rubik', Arial, Helvetica, sans-serif; font-size: 24px; font-weight: 800; color: #ffffff; letter-spacing: 0.3px;">Kopiao</span>
                </a>
            </td>
        </tr>

        <!-- Corps -->
        <tr>
            <td class="kp-email-padding" style="background-color:#ffffff; padding: 40px 40px 32px; border-left:1px solid #e5e7eb; border-right:1px solid #e5e7eb;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; line-height: 1.65; color: #2a2541;">
                    @yield('content')
                </td>
                </tr>
                </table>
            </td>
        </tr>

        <!-- Pied de page -->
        <tr>
            <td class="kp-email-padding" style="background-color:#f7f8fa; border-radius:0 0 14px 14px; border:1px solid #e5e7eb; border-top:none; padding: 26px 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 1.6; color: #6b7280;">
                    <p style="margin: 0 0 10px;">
                        <a href="{{ url('/') }}" style="color:#0B69F1; font-weight:600;">kopiao.com</a>
                        &nbsp;&middot;&nbsp;
                        <a href="mailto:{{ config('mail.from.address') }}" style="color:#0B69F1; font-weight:600;">Nous contacter</a>
                    </p>
                    <p style="margin: 0;">
                        &copy; {{ date('Y') }} Kopiao. Tous droits réservés.<br>
                        Vous recevez cet email car vous possédez un compte sur Kopiao.
                    </p>
                </td>
                </tr>
                </table>
            </td>
        </tr>

    </table>

</td>
</tr>
</table>
</body>
</html>
