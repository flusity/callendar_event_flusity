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
    'date_chosen' => 'Data selezionata',
    'registration_has_ended' => 'La registrazione è terminata',
    'available_times' => 'Orari disponibili',
    'duration_time'  => 'Durata',
    'methodical_material' => 'Materiale metodico',
    'registration' => 'Registrazione',
    'location' => 'Posizione',
    'practice' => 'Pratica',
    'audience' => 'Pubblico',
    'event_time_and_day_selected'=> 'Ora e giorno dell\'evento selezionati',
    'login_name' => 'Nome di login',
    'additional_information' => 'Informazioni aggiuntive',
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    'telephone' => 'Telefono',
    'email' => 'Email',
    'password' => 'Password',
    'repeat_password' => 'Ripeti la password',
    'institution' => 'Istituto',
    'institution_address' => 'Indirizzo Istituto',
    'invoice' => 'Fattura',
    'no' => 'No',
    'yes' => 'Sì',
    'employee_position' => 'Posizione del dipendente',
    'additional_information' => 'Informazioni aggiuntive',
    'register_event' => 'Registrati all\'evento',
    'not_selected_event_time' => 'Non hai selezionato un orario per l\'evento. La registrazione è attualmente sospesa. Si prega di riprovare più tardi.',
    'go_to' => 'Vai a',
    'home_page' => 'Pagina principale',
    'or' => 'o',
    'back_to' => 'ritorna a',
    'event_calendar' => 'Calendario eventi',
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
    'date_chosen' => 'Pasirinkta data',
    'registration_has_ended' => 'Registracija pasibaigusi',
    'available_times' => 'Pasiekiamas laikas',
    'duration_time'  => 'Trukmė',
    'methodical_material' => 'Methodinė medžiaga',
    'registration' => 'Registracija',
    'location' => 'Lokacija',
    'practice' => 'Veikla',
    'audience' => 'Auditorija',
    'event_time_and_day_selected'=> 'Pasirinktas laikas ir diena',
    'login_name' => 'Prisijungimo Vardas',
    'additional_information' => 'Papildoma informacija',
    'first_name' => 'Vardas',
    'last_name' => 'Pavardė',
    'telephone' => 'Telefonas',
    'email' => 'El. paštas',
    'password' => 'Slaptažodis',
    'repeat_password' => 'Pakartokite slaptažodį',
    'institution' => 'Įstaiga',
    'institution_address' => 'Įstaigos adresas',
    'invoice' => 'Sąskaita faktūra',
    'no' => 'Ne',
    'yes' => 'Taip',
    'employee_position' => 'Darbuotojo pareigos',
    'additional_information' => 'Papildoma informacija',
    'register_event' => 'Registruotis į renginį',
    'not_selected_event_time' => 'Nepasirinkote renginio laiko. Registracija šiuo metu sustabdyta. Bandykite dar kartą vėliau.',
    'go_to' => 'Eiti į',
    'home_page' => 'Pagrindinis puslapis',
    'or' => 'arba',
    'back_to' => 'grįžti į',
    'event_calendar' => 'Renginių kalendorius',
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
    'date_chosen' => 'Date chosen',
    'registration_has_ended' => 'Registration has ended',
    'available_times' => 'Available times',
    'duration_time'  => 'Duration time',
    'methodical_material' => 'Methodical material',
    'registration' => 'Registration',
    'location' => 'Location',
    'practice' => 'Practice',
    'audience' => 'Audience',
    'event_time_and_day_selected'=> 'Event time and day selected',
    'login_name' => 'Login Name',
    'additional_information' => 'Additional information',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'telephone' => 'Telephone',
    'email' => 'Email',
    'password' => 'Password',
    'repeat_password' => 'Repeat password',
    'institution' => 'Institution',
    'institution_address' => 'Institution Address',
    'invoice' => 'Invoice',
    'no' => 'No',
    'yes' => 'Yes',
    'employee_position' => 'Employee Position',
    'additional_information' => 'Additional information',
    'register_event' => 'Register event',
    'not_selected_event_time' => 'You have not selected an event time. Registration is currently suspended. Please try again later.',
    'go_to' => 'Go to',
    'home_page' => 'Home page',
    'or' => 'or',
    'back_to' => 'back to',
    'event_calendar' => 'Event calendar',
);


$translations_ = isset($translations_) ? $translations_ : []; 

$translations = ($selected_lang == $lang_code) ? array_merge($translations_, ${"translations_" . $lang_code}) : $translations_en;

?>