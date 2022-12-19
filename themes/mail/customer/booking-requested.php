<div width="100%" style="background: #003283; padding: 50px 20px; color: rgb(81, 77, 106);">
   <div style="max-width: 700px; margin: 0px auto; font-size: 14px;">
      <table cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px; border: 0px;">
         <tbody>
            <tr>
               <td style="vertical-align: top;"><img src="{{logo}}" alt="" style="height: 50px;"></td>
               <td style="text-align: right; vertical-align: middle;"><span style="color: #fff;">{{slogan}}</span></td>
            </tr>
         </tbody>
      </table>
      <div style="padding: 40px 40px 20px; background: rgb(255, 255, 255);">
         <table cellpadding="0" cellspacing="0" style="width: 100%; border: 0px;">
            <tbody>
               <tr>
                  <td>
                     <h3 style="margin-bottom: 20px; color: rgb(36, 34, 47); font-weight: 600;">{#mail_subject_request#}</h3>
                     <p>{#dear#} {{name}} {{surname}}</p>
                     <p>Your booking created successfully</p>
                     <p>
                        Code : {{code}}<br/>
                        Start Route : {{hotel_name}}  {{travel_city}}<br/>
                        End Route : {{place_end_country}}  > {{place_end_state}}
                     </p>
                     <p>{#regards#}</p>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <div style="text-align: center; font-size: 12px; color: #fff; margin-top: 20px;">
           <p>{{address}}<br>{#mail_footer_text#}<br>Powered by {{generator}}</p>
      </div>
   </div>
</div>