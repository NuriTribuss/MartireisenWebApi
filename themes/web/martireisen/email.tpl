
<style>
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }
      table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
        font-size: 16px !important;
      }
      table[class=body] .wrapper,
            table[class=body] .article {
        padding: 10px !important;
      }
      table[class=body] .content {
        padding: 0 !important;
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }
      table[class=body] .btn table {
        width: 100% !important;
      }
      table[class=body] .btn a {
        width: 100% !important;
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }
</style>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center">
<table style="min-height: 600px; background-image: url('{{url}}/public/mail/images/bg.jpg'); background-repeat: no-repeat; background-position: right 520px; border-bottom: 30px solid #ffcf03;" class="body" width="580" bgcolor="#fff">
<tbody>
<tr>
<td style="padding: 50px 30px;" align="center" valign="top"><!--Header -->
<table border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 100px; padding: 0; margin: 0; font-weight: normal;">
<table style="width: 100%;">
<tbody>
<tr>
<td><img src="{{email_logo}}" width="180" /></td>
<td>&nbsp;</td>
<td style="text-align: right;"><a style="display: inline-block; margin-left: 5px; vertical-align: middle;" href="{{facebook}}"> <img src="{{url}}/public/mail/images/4.png" width="35" /> </a> <a style="display: inline-block; margin-left: 5px; vertical-align: middle;" href="{{youtube}}"> <img src="{{url}}/public/mail/images/2.png" width="35" /> </a> <a style="display: inline-block; margin-left: 5px; vertical-align: middle;" href="{{instagram}}"> <img src="{{url}}/public/mail/images/14.png" width="35" /> </a> <a style="display: inline-block; margin-left: 5px; vertical-align: middle;" href="{{twitter}}"> <img src="{{url}}/public/mail/images/15.png" width="35" /> </a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--Header --> <!--Slogan and Code-->
<table style="margin-top: 70px;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 100px; padding: 0; margin: 0; font-weight: normal;">
<table style="width: 100%;">
<tbody>
<tr>
<td style="font-family: 'Raleway', Arial,sans-serif; font-weight: 600;" colspan="2">{{ language.mail_subject_request }}</td>
</tr>
<tr>
<td style="background-image: url('{{url}}/public/mail/images/5.png'); background-repeat: no-repeat; width: 400px; background-size: 100%; background-position: -15px 0; font-size: 24px; color: #fff; font-family: Arial; font-weight: bold; padding: 26px 0px;"><img style="vertical-align: middle; margin-left: 15px;" src="{{url}}/public/mail/images/check.png" width="36" height="36" /> <span style="vertical-align: middle;">{{ code }}</span></td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--Slogan and Code --> <!--Reiseteilnehmer-->
<table style="margin-top: 30px;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 100px; padding: 0; margin: 0; font-weight: normal;">
<table  width="550" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: 'Raleway', Arial,sans-serif; padding-bottom: 10px;" colspan="2"><strong>{{language.mail_travellers}}: </strong></td>
</tr>
<tr>
<td style="font-family: 'Raleway', Arial,sans-serif; padding-left: 10px;">
<ul style="width: 100%; list-style: decimal; padding: 0; margin: 0; font-size: 13px; font-weight: 500;">{{travellers_block | raw}}</ul>
</td>
<td style="width: 180px; font-family: 'Raleway', Arial,sans-serif; text-align: right; font-weight: 500; font-size: 11px; color: #000;">{{language.mail_contact_data}} <br />{{name}} {{surname}}<br />{{address}} , {{city}} {{country}} <br />{{email}}<br />{{traveller_phone}}</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--Reiseteilnehmer --> <!--cards-->
<table style="margin-top: 70px;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 0; margin: 0; font-weight: normal;">
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="width: 230px; height: 355px;background: white;
    border: 1px solid silver;
    border-radius: 30px;   background-size: 110%; background-repeat: no-repeat; font-family: 'Raleway', Arial,sans-serif; text-align: center; color: #2c3849; background-position: -14px 0px; vertical-align: top;"><img style="width: 230px; margin-top: 50px;" src="{{hotel_image}}" />
<div style="text-align: left; padding-left: 20px;"><strong style="font-size: 18px; font-weight: bold; display: block; text-align: left; margin-top: 10px;"> {{hotel_name}} </strong> <span style="margin-top: 6px; display: block; text-align: left;"> <img src="{{url}}/public/mail/images/6.png" width="18" height="17" /> <img src="{{url}}/public/mail/images/6.png" width="18" height="17" /> <img src="{{url}}/public/mail/images/6.png" width="18" height="17" /> <img src="{{url}}/public/mail/images/6.png" width="18" height="17" /> <img src="{{url}}/public/mail/images/6.png" width="18" height="17" /> </span> <span style="margin-top: 6px; display: block; font-size: 12px; font-weight: 500; text-align: left;"> {{travel_city}} </span>
<ul style="padding: 0; margin: 10px 0 0 0; list-style: none;">
<li style="width: 100%; margin-bottom: 5px; float: left; display: inline-block; font-size: 12px; font-weight: 500;"><img style="margin-right: 4px;" src="{{url}}/public/mail/images/7.png" width="10" height="10" /> {{ duration }} Nachte</li>
<li style="width: 100%; margin-bottom: 5px; float: left; display: inline-block; font-size: 12px; font-weight: 500;"><img style="margin-right: 4px;" src="{{url}}/public/mail/images/7.png" width="10" height="10" /> {{ adult_count }} Erwachsene</li>
{% if children_count > 0  %}
<li style="width: 100%; margin-bottom: 5px; float: left; display: inline-block; font-size: 12px; font-weight: 500;"><img style="margin-right: 4px;" src="{{url}}/public/mail/images/7.png" width="10" height="10" /> {{ children_count }} Kind</li>
{% endif %}
<li style="display: inline-block; width: 100%; margin-bottom: 5px; float: left; font-size: 12px; font-weight: 500;"><img style="margin-right: 4px;" src="{{url}}/public/mail/images/7.png" width="10" height="10" /> Hin - und R&uuml;ckflug</li>
<li style="clear: both;">&nbsp;</li>
</ul>
</div>
</td>
<td style="width: 230px; height: 355px; color: #2c3849; background: white;
    border: 1px solid silver;
    border-radius: 30px;   background-size: 110%; font-family: 'Raleway', Arial,sans-serif; background-repeat: no-repeat; background-position: -14px 0px; vertical-align: top;">{% for transport in transports %} {% if transport.direction == 'out' %} <!--Gidiş -->
<div style="text-align: left; padding-top: 50px; padding-left: 11px; padding-right: 11px;">
<div style="margin-left: 15px;"><strong style="font-size: 18px;"> <img style="margin-right: 5px;" src="{{url}}/public/mail/images/9.png" width="28" height="11" /> Hinflug - {{transport.dep_date}} </strong> <span style="margin-top: 15px; display: block; font-size: 11px;"> {{transport.airline}} </span></div>
<table style="width: 100%; background-color: #eaeaea; margin-top: 2px;">
<tbody>
<tr>
<td style="font-size: 11px; font-weight: 600; padding-left: 14px;">{{transport.dep_name}} <span style="margin-left: 3px; font-weight: 400;">({{transport.dep_iata}})</span></td>
<td style="vertical-align: middle;" width="9"><img src="{{url}}/public/mail/images/11.png" width="11" height="11" /></td>
<td style="font-size: 11px; font-weight: 600; text-align: right; padding-right: 14px;">{{transport.arr_name}} <span style="margin-left: 3px; font-weight: 400;">({{transport.arr_iata}})</span></td>
</tr>
</tbody>
</table>
<table style="width: 100%;">
<tbody>
<tr>
<td style="font-family: 'Calibri',sans-serif; font-size: 25px; font-weight: bold; padding-left: 14px;">{{transport.dep_time}}</td>
<td style="font-size: 11px; vertical-align: middle;" width="9">Direktflug</td>
<td style="font-family: 'Calibri',sans-serif; font-size: 25px; font-weight: bold; text-align: right; padding-right: 14px;">{{transport.arr_time}}</td>
</tr>
</tbody>
</table>
</div>
{% else %} <!--Dönüş -->
<div style="text-align: left; padding-top: 30px; padding-left: 11px; padding-right: 11px;">
<div style="margin-left: 15px;"><strong style="font-size: 18px;"> <img style="margin-right: 5px;" src="{{url}}/public/mail/images/10.png" width="28" height="11" /> R&uuml;ckflug - {{transport.arr_date}} </strong> <span style="margin-top: 15px; display: block; font-size: 11px;"> {{transport.airline}} </span></div>
<table style="width: 100%; background-color: #eaeaea; margin-top: 2px;">
<tbody>
<tr>
<td style="font-size: 11px; font-weight: 600; padding-left: 14px;">{{transport.dep_name}} <span style="margin-left: 3px; font-weight: 400;">({{transport.dep_iata}})</span></td>
<td style="vertical-align: middle;" width="9"><img src="{{url}}/public/mail/images/11.png" width="11" height="11" /></td>
<td style="font-size: 11px; font-weight: 600; text-align: right; padding-right: 14px;">{{transport.arr_name}} <span style="margin-left: 3px; font-weight: 400;">({{transport.arr_iata}})</span></td>
</tr>
</tbody>
</table>
<table style="width: 100%;">
<tbody>
<tr>
<td style="font-family: 'Calibri',sans-serif; font-size: 25px; font-weight: bold; padding-left: 14px;">{{transport.dep_time}}</td>
<td style="font-size: 11px; vertical-align: middle;" width="9">Direktflug</td>
<td style="font-family: 'Calibri',sans-serif; font-size: 25px; font-weight: bold; text-align: right; padding-right: 14px;">{{transport.arr_time}}</td>
</tr>
</tbody>
</table>
</div>
<!--Dönüş --> {% endif %} <!--Gidiş --> {% endfor %}</td>
</tr>
<tr>
<td style="height: 300px; background-image: url('{{url}}/public/mail/images/18.png'); background-size: 100%; vertical-align: top; color: #2c3849; background-repeat: no-repeat;" colspan="2">
<div style="padding: 40px;"><!--Total -->
<table style="width: 100%; font-family: 'Calibri',sans-serif;">
<tbody>
<tr>
<td style="vertical-align: top; font-size: 20px; font-weight: bold;">{{language.mail_price_total}}</td>
<td style="vertical-align: top; font-weight: bold; font-size: 20px; text-align: right;">{{amount | format }} {{currency}}</td>
</tr>
<tr>
<td style="vertical-align: top; font-size: 20px; font-weight: 500;">Enrgelt f&uuml;r Zahlungsart <span style="display: block; font-size: 16px;"> (Rechnung) </span></td>
<td style="vertical-align: top; font-weight: 500; font-size: 20px; text-align: right;">0,00 {{currency}}</td>
</tr>
<tr>
<td style="vertical-align: top; padding-top: 20px; font-size: 22px; font-weight: 600;">{{language.mail_price_total}} <span style="display: block; font-size: 16px;"> inkl. aller Zuschlage </span></td>
<td style="vertical-align: top; padding-top: 20px; font-weight: bold; font-size: 30px; text-align: right;">{{amount | format}} {{currency}}</td>
</tr>
</tbody>
</table>
<!--Total --></div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<br />
<div style="text-align: left;"><strong>1.</strong>{{ language.booking_complete_step1 }}<br /><br /><strong>2.</strong>{{ language.booking_complete_step2 }}<br /><br /><strong>3.</strong>{{ language.booking_complete_step3 }}<br /><br /><!--cards --> <!--Text--> <!--Text --> <!--Social Media --><strong>4.</strong>{{ language.booking_complete_step4 }}<br /><!--cards --> <!--Text--></div>
<!--Text --> <!--Social Media -->
<table style="margin-top: 20px; height: 91px;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr style="height: 101px;">
<td style="height: 73px; padding: 0px; margin: 0px; font-weight: normal; width: 546px;">
<table style="width: 100%; text-align: center;">
<tbody>
<tr>
<td><a style="display: inline-block; margin: 5px; vertical-align: middle;" href="{{facebook}}"> <img src="{{url}}/public/mail/images/4.png" width="35" /> </a> <a style="display: inline-block; margin: 5px; vertical-align: middle;" href="{{youtube}}"> <img src="{{url}}/public/mail/images/2.png" width="35" /> </a> <a style="display: inline-block; margin: 5px; vertical-align: middle;" href="{{instagram}}"> <img src="{{url}}/public/mail/images/14.png" width="35" /> </a> <a style="display: inline-block; margin: 5px; vertical-align: middle;" href="{{twitter}}"> <img src="{{url}}/public/mail/images/15.png" width="35" /> </a></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 18px;">
<td style="padding: 0px; margin: 0px; font-weight: normal; width: 546px; height: 18px; text-align: center;"><span style="font-size: 18pt;"><strong>{{phone}}</strong></span></td>
</tr>
</tbody>
</table>
<span style="font-size: 18pt;"><strong><!--Social Media --> <!--Footer--></strong></span>
<table style="margin-top: 30px; margin-left: auto; margin-right: auto;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 100px; padding: 0; margin: 0; font-weight: normal;">
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: 'Raleway', Arial,sans-serif; padding-left: 10px; vertical-align: top;">
<ul style="width: 100%; list-style: none; padding: 0; margin: 0; font-size: 13px; font-weight: 500;">
<li><span style="color: #2c3849; font-size: 11px; font-weight: 500;">Service &amp; Kontakt</span></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">Datenshutzbestimmurng</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">Agb</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}/de/impressum">Impressum</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">Haufig gestellte Fragen</a></li>
</ul>
</td>
<td style="font-family: 'Raleway', Arial,sans-serif; padding-left: 10px; vertical-align: top;">
<ul style="width: 100%; list-style: none; padding: 0; margin: 0; font-size: 13px; font-weight: 500;">
<li><span style="color: #2c3849; font-size: 11px; font-weight: 500;">Uber Uns</span></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">StartSeite</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}/de/ueber-martireisen">Uber Marti Reisen</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">Warum Martireisen.at?</a></li>
<li><a style="color: #2c3849; font-size: 11px; font-weight: 500;" href="{{url}}">Buchungsablauf</a></li>
</ul>
</td>
<td style="font-family: 'Raleway', Arial,sans-serif; text-align: right; font-weight: 500; font-size: 11px; color: #2c3849; vertical-align: top;">Hotline <br />Unser Service Team <br />st gerne von 08:00 - 22:00 Uhr<br />(auch an Sonn- und Feiertagen)<br />f&uuml;r Sie da. Einfach anrufen unter:</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--Footer --> <!--Copyright-->
<table style="margin-top: 20px; margin-left: auto; margin-right: auto;" border="0" width="550" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 100px; padding: 0; margin: 0; font-weight: 500; font-family: 'Raleway', Arial,sans-serif; color: #2c3849;">
<table style="width: 100%; text-align: center;">
<tbody>
<tr>
<td>
<p style="font-size: 14px;">&copy;Copyright &copy; 1999 - 2020 Marti Reisen. Alle Rechte vorbehalten</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--Copyright --></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>