<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
/* error_reporting(E_ALL);
ini_set('display_errors', 1);
 */

$selected_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang_code;

$translations_it = array(
    'contact_us' => 'Contattaci',
     'interesting_theme' => 'Tema interessante',
     'your_email' => 'La tua email posta',
     'message' => 'Messaggio',
     'human_check' => 'Verifica se sei umano',
     'drag_answer' => 'Trascina la risposta qui',
     'send' => 'Invia',
     'dashboard' => 'cruscotto',
     'profile' => 'Profilo',
     'signout' => 'Esci',
     '404_tropic'=> 'Hai vagato nell\'ignoto tropicale! Non vedrai nulla qui.',
     '404_return_home'=>'Fai clic <a href="/">qui</a> per tornare alla home page.',
     'repeat' => 'Ripeti?',
     'hours' => 'ore',
     'minutes' => 'min.',
     'Audience' => 'Pubblico',
     'date_chosen' => 'Data selezionata',
     'registration_has_ended' => 'La registrazione è terminata',
     'available_times' => 'Orari disponibili',
     'duration_time'  => 'Durata',
     'methodical_material' => 'Materiale metodico',
     'registration' => 'Registrazione',
     'location' => 'Posizione'
);

$translations_lt = array(
    'contact_us' => 'Susisiekime',
     'interesting_theme' => 'Dominanti tema',
     'your_email' => 'Jūsį el. paštas',
     'message' => 'Žinutė',
     'human_check' => 'Patikrinama ar esate žmogus',
     'drag_answer' => 'Vilkite atsakymą čia',
     'send' => 'Siųsti',
     'dashboard' => 'Prietaisų skydelis',
     'profile' => 'Profilis',
     'signout' => 'Atsijungti',
     '404_tropic'=> 'Jūs nuklydote į atogrąžų nežinią! Nieko čia nepamatysi.',
     '404_return_home'=>'Spustelėkite <a href="/">čia</a>, kad grįžtumėte į pagrindinį puslapį.',
     'repeat' => 'Kartoti?',
     'hours' => 'val.',
     'minutes' => 'min.',
     'Audience' => 'Auditorija',
     'date_chosen' => 'Pasirinkta data',
     'registration_has_ended' => 'Registracija pasibaigusi',
     'available_times' => 'Pasiekiamas laikas',
     'duration_time'  => 'Trukmė',
     'methodical_material' => 'Methodinė medžiaga',
     'registration' => 'Registracija',
     'location' => 'Lokacija'
);

$translations_en = array(
    'contact_us' => 'Contact Us',
    'interesting_theme' => 'Interesting Theme',
    'your_email' => 'Your Email',
    'message' => 'Message',
    'human_check' => 'Human Check',
    'drag_answer' => 'drag the answer here',
    'send' => 'Send',
    'dashboard' => 'Dashboard',
    'profile' => 'Profile',
    'signout' => 'Sign out',
    '404_tropic'=> 'You\'ve wandered off into tropical limbo! You won\'t see anything here.',
    '404_return_home'=>'Click <a href="/">here</a>, to return back home page.',
    'repeat' => 'Repeat?',
    'hours' => 'hr.',
    'minutes' => 'min.',
    'Audience' => 'Audience',
    'date_chosen' => 'Date chosen',
    'registration_has_ended' => 'Registration has ended',
    'available_times' => 'Available times',
    'duration_time'  => 'Duration time',
    'methodical_material' => 'Methodical material',
    'registration' => 'Registration',
    'location' => 'Location'
);


$translations_ = isset($translations_) ? $translations_ : []; 

$translations = ($selected_lang == $lang_code) ? array_merge($translations_, ${"translations_" . $lang_code}) : $translations_en;

?>