<link rel="stylesheet" href="{{ theme_dir }}/assets/css/newsletter.css"/>
<style>.error-message { display:none; }</style>
<div class="section pt-5 pb-4  d-lg-block">

    <div class="section-content mb-4">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-5">
                            <h1>
                                Waaaouuuuw! Top- Angebote und exklusive Reiseideen <br>
                                mit Ihrem Marti Reisen Newsletter!
                            </h1>
                            <p>
                                Jetzt Registrieren und einen 20 € Reisegutschein für Ihren nächsten Urlaub erhalten
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="newsletter-image">
                            <div class="newsletter-price">
                                <span>Sofort</span>
                                <strong>20€</strong>
                                <span>Reisegutschein!</span>
                            </div>
                            <img src="{{ theme_dir }}/assets/img/newsletter/1.jpg">
                        </div>
                    </div>
                    <div class="col-lg-6" id="newsletter">
                        <div class="newsletter-form-wrapper">
                            <div class="newsletter-form-header">
                                <strong>Erstellen Sie Ihr Konto</strong> und viele Vorteile sichern*
                            </div>
                            <div class="newsletter-form-content">
                                <div class="newsletter-form w-75">
                                    <div class="newsletter-form-item mb-2">
                                        <input type="text" v-on:keyup="keyInput('name')" v-model="form.name" placeholder="Vorname"/>
                                        <span class="error-message text-danger" id="newsletter_name">{{ 'user.name_error_message' | translate }}</span>
                                    </div>
                                    <div class="newsletter-form-item mb-2">
                                        <input type="text" v-on:keyup="keyInput('surname')" v-model="form.surname" placeholder="Nachname"/>
                                        <span class="error-message text-danger" id="newsletter_surname" >{{ 'user.lastname_error_message' | translate }}</span>
                                    </div>
                                    <div class="newsletter-form-item mb-2">
                                        <input type="text" v-on:keyup="keyInput('username')" v-model="form.username" placeholder="Email Address"/>
                                        <span class="error-message text-danger" id="newsletter_username">{{ 'user.email_error_message' | translate }}</span>
                                    </div>
                                    <div class="newsletter-form-item mb-2">
                                        <input type="password" v-on:keyup="keyInput('password')" v-model="form.password" placeholder="Password"/>
                                        <span class="error-message text-danger" id="newsletter_password">{{ 'user.password_error_message' | translate }}</span>
                                    </div>
                                   
                                    <div class="newsletter-form-item">
                                        <div class="mt-2 mb-2">
                                            <div class="mb-1">
                                                <span>{{ 'user.profile.gender' | translate }} : </span>
                                            </div>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" v-model="form.gender" name="gender" id="male" value="0"/>
                                                    <label class="form-check-label" for="male">{{ 'user.profile.male' | translate }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" v-model="form.gender" name="gender" id="female" value="1"/>
                                                    <label class="form-check-label" for="female">{{ 'user.profile.female' | translate }}</label>
                                                </div>
                                            </div>
                                            <span class="error-message text-danger" id="newsletter_password">{{ 'user.password_error_message' | translate }}</span>

                                        </div>
                                    </div>


                                    <div class="newsletter-form-button">
                                        <button class="btn btn-warning btn-block" v-on:click="register">Jetzt Kostenlos Anmelen</button>
                                        <div class="mt-3">
                                            <small>
                                                Wenn Sie sich in Ihrem Konto anmelden oder ein Konto erstellen,
                                                erklären Sie sich mit unseren AGB und Datenschutzbestimmungen
                                                einverstanden.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="newsletter-social-media d-none">
                                    <div class="mt-3 mb-2">
                                        <span>
                                            oder melden Sie sich mit einem Klick an
                                        </span>
                                    </div>
                                    <div class="newsletter-social-media-buttons">
                                        <button class="btn btn-block btn-facebook">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>Melden Sie sich bei Facebook an</span>
                                        </button>
                                        <button class="btn btn-block btn-google">
                                            <i class="fab fa-google"></i> <span>Melden Sie sich bei Google an</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="newsletter-proposal">
                <div class="row">
                    <div class="col-12">
                        <div class="newsletter-proposal-header">
                            <stron>Unser Newsletter:</stron>
                            Reiseideen, Gewinnspiele & tolle Schnäppchenangebote
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="newsletter-proposal-image">
                            <img src="{{ theme_dir }}/assets/img/newsletter/6.jpg">
                                <div class="newsletter-proposal-image-description">
                                    Registrieren und viele Vorteile sichern!
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="newsletter-proposal-description">
                            <div class="mb-2">
                                <span>
                                    Ihre Vorteile
                                </span>
                            </div>
                            <div>
                                <ul>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <strong>Sofort 20€ Reisegutschein</strong>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Wöchentlich neue, exklusive Angebote </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Von unseren Reiseexperten recherchiert</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Kein Schnäppchen mehr verpassen </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Monatliche Gewinnspiele </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="newsletter-inspiration">
                <div class="newsletter-inspiration-container">
                    <div class="row">
                        <div class="col-12">
                            <div class="newsletter-inspiration-header">
                                INSPIRATION im martireisen.at NEWSLETTER
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="newsletter-inspiration-item">
                                <div class="newsletter-inspiration-item-image">
                                    <img src="{{ theme_dir }}/assets/img/newsletter/2.jpg">
                                </div>
                                <div class="newsletter-inspiration-item-description">
                                    Themen passend
                                    zum aktuellen
                                    Geschehen
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="newsletter-inspiration-item">
                                <div class="newsletter-inspiration-item-image">
                                    <img src="{{ theme_dir }}/assets/img/newsletter/3.jpg">
                                </div>
                                <div class="newsletter-inspiration-item-description">
                                    Anregungen
                                    für neue Reiseideen
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="newsletter-inspiration-item">
                                <div class="newsletter-inspiration-item-image">
                                    <img src="{{ theme_dir }}/assets/img/newsletter/4.jpg">
                                </div>
                                <div class="newsletter-inspiration-item-description">
                                    Lassen Sie sich von
                                    aktuellen
                                    Blogeinträgen
                                    inspirieren
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="newsletter-inspiration-item">
                                <div class="newsletter-inspiration-item-image">
                                    <img src="{{ theme_dir }}/assets/img/newsletter/5.jpg">
                                </div>
                                <div class="newsletter-inspiration-item-description">
                                    Keinen Trend
                                    mehr verpassen
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="newsletter-description">
                <div class="mb-4">
                    <strong>
                        *Datenschutzerklärung & Widerrufsrecht
                    </strong>
                </div>
                <div>
                    <p>
                        Ich stimme gemäß Abschnitt 3. F der Datenschutzbestimmungen zu, personalisierte Angebote
                        bezüglich der von der martireisen.at oder seinen
                        Partnern angebotenen Dienstleistungen zu erhalten. Diese Angebote werden durch die Erstellung
                        eines Profils und die automatische Verarbeitung
                        meiner Daten personalisiert, um relevanter für mich zu sein. Ich kann sie per Post, E-Mail, SMS,
                        Telefon oder Online-Anzeigen erhalten. Die
                        Abmeldung vom Newsletter ist jederzeit möglich und kann entweder durch eine Nachricht an die
                        unten beschriebene Kontaktmöglichkeit oder über
                        einen dafür vorgesehenen Link im Newsletter erfolgen. Nach Abmeldung löschen wir Ihre
                        E-MailAdresse, soweit Sie nicht ausdrücklich in eine
                        weitere Nutzung Ihrer Daten eingewilligt haben oder wir uns eine darüber hinausgehende
                        Datenverwendung vorbehalten, die gesetzlich erlaubt ist
                        und über die wir Sie in dieser erklärung informieren.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    window.addEventListener("load", function (event) {
        
        window.newsletter = new Vue({
            
            el: '#newsletter',
            data: {
              form : {
                  name          : '',
                  surname       : '',
                  gender        : 0,
                  username      : '',
                  password      : '',
                  newsletter    : 1
              },
              
            },
            methods : {
                
                register : function(){
                    
                    var formData = new FormData;
                    var keys = Object.keys(this.form);
                    for(var i = 0; i < keys.length; i++){
                        formData.append(keys[i] , this.form[keys[i]]);
                    }
                    var _this = this;
                    axios.post("/service/customers/save",formData).then(function(r){
                        if(r.data.status){
                            swal(Marti.Locale.get('common.success'), r.data.message, 'success');
                            _this.form = { };
                        }else{
                            if(r.data.data.field){
                                let dom = r.data.data.field;
                                $("#newsletter_"+dom).show();
                            }
                        }
                        
                        return false;
                    });
                },
                
                keyInput : function(dom){
                    $("#newsletter_"+dom).hide();
                }
            }
        });

    });

</script>
