{{--
    Bouton d'action email-safe (table + VML pour Outlook).
    Props attendues : $url, $text, $color (optionnel, défaut bleu Kopiao)
--}}
@php
    $color = $color ?? '#0B69F1';
@endphp
<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin: 28px 0;">
<tr>
<td align="center" style="border-radius: 8px; background-color: {{ $color }};">
    <!--[if mso]>
    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:48px;v-text-anchor:middle;width:260px;" arcsize="16%" strokecolor="{{ $color }}" fillcolor="{{ $color }}">
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:Arial,sans-serif;font-size:15px;font-weight:bold;">{{ $text }}</center>
    </v:roundrect>
    <![endif]-->
    <!--[if !mso]><!-->
    <a href="{{ $url }}" target="_blank" style="display:inline-block; padding: 14px 32px; font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px;">
        {{ $text }}
    </a>
    <!--<![endif]-->
</td>
</tr>
</table>
