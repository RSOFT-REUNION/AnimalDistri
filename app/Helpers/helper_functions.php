<?php

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Users\Cities;
use Illuminate\Support\Facades\Storage;
use League\Glide\Urls\UrlBuilderFactory;

function getActive($active)
{
    if ($active == 0) {
        echo '<span style="color: #b02a37;"><i class="fa-solid fa-rectangle-xmark fa-2x"></i></span>';
    } else {
        echo '<span style="color: #198754;"><i class="fa-solid fa-square-check fa-2x"></i></span>';
    }
}

function getImageUrl(string $image, ?int $width = null, ?int $height = null, ?string $fit = null)
{
    /*** verifie que l'image existe, sinon retroune l'image par default ***/
    if(Storage::files('/public'.$image)) {
        $image = '/no-image.png';
    }

    if ($width === null) {
        return '/storage'.$image;
        //return '/storage/upload/catalog/products/'.$this->product_id.'/'.$this->name;
    }
    $urlBuilder = UrlBuilderFactory::create('/images/', config('laravel-glide.key'));
    return $urlBuilder->getUrl($image, ['w' => $width, 'h' => $height, 'fit' => $fit]);
}

function getProductInfos($produit)
{
    $productinfo = Product::where('id', $produit)->first();
    return $productinfo;
}
function getCategoryParentInfo($category)
{
    return Category::where('id', $category)->first();
}
function removeStorageFromURL($path)
{
    return substr($path, 8);
}

function formatPriceToInteger($input) {
    return round($input * 100);
}

function formatPriceToFloat($input) {
        return number_format(($input / 100), 2, ',', ' ') ;
}

function formatStocktoInteger($input) {
    return round($input  * 1000);
}

function formatStockToFloat($input) {
    return number_format(($input  / 1000), 3, ',', ' ');
}

function arrayToString(array $array)
{
    $retrun = '?';
    foreach ($array as $key => $value) {
        $retrun .= '&'.$key.'='.$value;
    }
    echo $retrun;
}

/*** Recupere la region avec le code potal ***/
function getRegion(int $postal_code)
{
    return Cities::where('postal_code', $postal_code)->pluck('region')->first();
}
/*** Fonction qui retourne les dates sur les 2 prochaines semaine ***/
function getDateTimeNow()
{
    $tz = 'Indian/Reunion';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    return $dt->format('H:i');
}
function getDateDayNow()
{
    $tz = 'Indian/Reunion';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    return $dt->format('Y-m-d');
}
function getDateDayPlusOne()
{
    $tz = 'Indian/Reunion';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    $dt->modify('+1 day'); //add one day
    return $dt->format('Y-m-d');
}


function getDaysTwoWeeks(string $region)
{
    // Créer un objet DateTime avec la date actuelle et le fuseau horaire local
    $timezone = new DateTimeZone('Indian/Reunion');
    $date = new DateTime('now', $timezone);

    // Trouver le lundi de la semaine en cours
    $dayOfWeek = $date->format('N'); // N donne le numéro du jour (1 pour lundi, 7 pour dimanche)
    if ($dayOfWeek != 1) { // Si ce n'est pas lundi
        $date->modify('last Monday');
    }

    // Liste des jours que nous recherchons en anglais et leur traduction en français
    if ($region == 'nord') {
        $targetDays = [
            'Monday' => 'Lundi',
            'Wednesday' => 'Mercredi',
            'Friday' => 'Vendredi'
        ];
    } else {
        $targetDays = [
            'Tuesday' => 'Mardi',
            'Thursday' => 'Jeudi',
            'Saturday' => 'Samedi'
        ];
    }
    $possibleDays = getDaysOverTwoWeeks($date, $targetDays);
    return $possibleDays;
}

// Fonction pour trouver les jours possibles sur 2 semaines
function getDaysOverTwoWeeks(DateTime $date, array $days)
{
    $results = [];
    $interval = new DateInterval('P1D'); // Intervalle d'un jour
    $period = new DatePeriod($date, $interval, 13); // Période de 14 jours
    foreach ($period as $day) {
        $dayName = $day->format('l');
        $isTargetDay = array_key_exists($dayName, $days); // Vérifie si le jour est ciblé
        $results[] = [
            'date' => $day->format('Y-m-d'), // Format de date sans fuseau horaire
            'formatted_date' => formatDateFrench($day->format('Y-m-d')), // Date formatée en français
            'is_target_day' => $isTargetDay // Indication si c'est un jour ciblé
        ];
    }
    return $results;
}

// Fonction pour formater la date en français
function formatDateFrench($date)
{
    $daysOfWeek = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche'
    ];

    $monthsOfYear = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Août',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre'
    ];

    $dateTime = new DateTime($date);
    $dayName = $daysOfWeek[$dateTime->format('l')];
    $day = $dateTime->format('d');
    $month = $monthsOfYear[$dateTime->format('F')];
    $year = $dateTime->format('Y');

    return "$dayName $day $month $year";
}

// Fonction pour formater une date en français
function formatDateInFrench(string $dateString)
{
    // Convertir la chaîne de date en objet DateTime avec le fuseau horaire Indian/Reunion
    $date = DateTime::createFromFormat('Y-m-d', $dateString, new DateTimeZone('Indian/Reunion'));

    // Vérifier si la création de l'objet DateTime a réussi
    if ($date === false) {
        throw new Exception("Invalid date format: $dateString");
    }

    // Créer le formateur pour afficher la date en français
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Indian/Reunion',
        IntlDateFormatter::GREGORIAN
    );

    return $formatter->format($date);
}
function formatDateInFrenchShort(string $dateString, string $dateFormat = 'Y-m-d')
{
    // Convertir la chaîne de date en objet DateTime
    $date = DateTime::createFromFormat($dateFormat, $dateString);

    // Vérifier si la création de l'objet DateTime a réussi
    if ($date === false) {
        throw new Exception("Invalid date format: $dateString");
    }

    // Créer le formateur pour afficher la date en français
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,  // Type de format de la date (FULL, LONG, MEDIUM, SHORT)
        IntlDateFormatter::NONE,
        'Europe/Paris',           // Fuseau horaire
        IntlDateFormatter::GREGORIAN,
        'EEE d'                   // Format personnalisé (Jour abrégé suivi du jour numérique)
    );

    // Formater et retourner la date
    return $formatter->format($date);
}

// Fonction pour convertir une chaîne de caractères en objet DateTime
function convertToDateTime(string $dateString): DateTime
{
    $timezone = new DateTimeZone('Indian/Reunion');
    return DateTime::createFromFormat('d-m-Y', $dateString, $timezone);
}




/****
*****
* SYSTEM PAY
*****
****/
function generateSignature($data) {
    ksort($data); // Trie les champs par ordre alphabétique
    $concatenatedValues = implode('+', array_values($data));
    $key = 'payment.key.'.config('payment.obligatory_fields.vads_ctx_mode');
    $key = config($key); // clé de test ou de production
    $message = $concatenatedValues . '+' . $key;
    $signature = base64_encode(hash_hmac('sha256', $message, $key, true));
    return $signature;
}

function generateUniqueAn6()
{
    // Obtenez la date actuelle au format YYYYMMDD
    $date = date('Ymd');

    // Générer une partie aléatoire
    $randomPart = bin2hex(random_bytes(3)); // 6 caractères aléatoires

    // Combinez la date et la partie aléatoire pour créer une chaîne unique
    $uniqueString = $date . $randomPart;

    // Hachez la chaîne combinée pour garantir l'unicité et la distribuer de manière uniforme
    $hash = substr(hash('sha256', $uniqueString), 0, 6);

    return strtoupper($hash); // Convertir en majuscule pour l'alphanumérique
}



