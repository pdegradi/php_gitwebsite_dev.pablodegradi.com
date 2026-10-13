<?php
/**
 * config.php
 * Shared variables, loaded by every page of the site.
 * This is an internal file: it must not be requested directly (see the
 * guard below), it is only meant to be required by entry-point pages.
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

/**
 * Debug mode: controls error visibility.
 * true  (development): every error is shown on screen.
 * false (production):  no error is ever shown, only logged.
 */
$app_debug = true;

error_reporting(E_ALL);
if ($app_debug) {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    // ini_set('error_log', __DIR__ . '/../error.log'); // uncomment for a custom log file
}

$nome             = "Pablo";
$nome_cognome     = "Pablo Degradi";
$site_description = "Gestionali custom, siti web e AI per professionisti e piccole attività.";
$site_lang        = "it";
$site_url         = "https://dev.pablodegradi.com";

// Contatti: sostituisci i valori segnaposto prima della pubblicazione.
$email            = "dev@pablodegradi.com";
// Sostituisci questo segnaposto con il link pubblico del tuo Google Form.
$google_form_url  = "https://docs.google.com/forms/d/e/1FAIpQLSeeqdjQ1WbhSutCyKV4cRE9EuteLsLro7HXmlesBPhSAJlTGw/viewform?usp=publish-editor";
// Termine ordinario per le richieste che non diventano un rapporto professionale.
$contact_request_retention = "12 mesi dall'ultimo contatto";
$linkedin_url     = "https://www.linkedin.com/in/pablo-degradi";
$youtube_channel_url = "https://www.youtube.com/@pablo-ai-pratica";

// Identità professionale e dati per le pagine legali.
$vat_number       = "10407410967";
$business_address = "Via Gaetano Airaghi";

// Hosting delle pagine statiche. GitHub Pages registra gli IP per sicurezza:
// la durata dei suoi log non e' un'impostazione di questo sito.
$hosting_provider = 'GitHub Pages';

// cPanel e' il pannello di gestione, non la societa' che ospita la posta.
// Facoltativo nell'informativa: inserisci qui il nome indicato nel contratto email.
$email_provider = '';


/**
 * Article sorting, used by blog-progetti.php.
 * $article_sort_by:    'title' or 'date'
 * $article_sort_order: 'asc' or 'desc'
 */
$article_sort_by    = 'date';
$article_sort_order = 'desc';

// Number of articles shown per page on blog-progetti.php.
$blog_page_size = 10;

/**
 * Database connection (MariaDB via PDO). Not used anywhere yet: the
 * framework has no database-backed page. Fill in real values and call
 * get_db_connection() (see includes/functions.php) when you need it.
 * Usage examples: includes/db-examples.php.
 */
$db_host    = '127.0.0.1';
$db_port    = 3306;
$db_name    = 'nome_database';
$db_user    = 'utente';
$db_pass    = 'password';
$db_charset = 'utf8mb4';

/**
 * Session lifetime, in minutes. Not used anywhere yet: call
 * start_app_session() (see includes/functions.php) when you need
 * sessions. Usage examples: includes/session-examples.php.
 */
$session_lifetime_minutes = 60;



$articles_folder = "articles";
// youtube_url: link HTTPS facoltativo. sn_frontpage: solo 's' mostra l'articolo in home.
$articles = [
    [
        'slug' => 'liberatorie-online-eventi',
        'file' => 'articles/0001-liberatorie-online-eventi.php',
        'title' => 'Liberatorie online per eventi: come raccoglierle e organizzarle',
        'seo_title' => 'Liberatorie online per eventi e firme',
        'excerpt' => 'Come raccogliere le liberatorie prima e durante un evento, tenere traccia delle firme e ritrovare i documenti. Il prototipo WaiverHub.',
        'seo_description' => 'Raccolta di liberatorie online per eventi: invio del link, firma da smartphone, registro partecipanti e documenti. Il prototipo WaiverHub.',
        'category' => 'Gestionali custom',
        'featured_image' => '/assets/images/0001/0022_lista-eventi.png',
        'image_alt' => 'Schermata WaiverHub con l’elenco degli eventi e le azioni disponibili',
        'gallery_folder' => '0001',
        'date' => '2026-09-20',
        'status' => 'pubblicato',
        'visible' => true,
        'youtube_url' => 'https://youtu.be/rIoZ-OL2Y9s',
        'sn_frontpage' => 's',
    ],
    [
        'slug' => 'gestione-segnalazioni-condominiali',
        'file' => 'articles/0002-gestione-segnalazioni-condominiali.php',
        'title' => 'Segnalazioni condominiali: come gestire guasti e interventi',
        'seo_title' => 'Segnalazioni condominiali: gestione guasti',
        'excerpt' => 'Un percorso chiaro per raccogliere i guasti, seguire gli interventi e confermare la soluzione. L’esempio di una web app dimostrativa.',
        'seo_description' => 'Come gestire le segnalazioni condominiali senza perdere richieste tra email e telefonate: ticket, stati, aggiornamenti e conferma della risoluzione.',
        'category' => 'Gestionali custom',
        'featured_image' => '/assets/images/0002/segnalazioni.png',
        'image_alt' => 'Elenco delle segnalazioni condominiali con categoria, priorità e stato',
        'gallery_folder' => '0002',
        'gallery_captions' => [
            '0025-EaseUS_2026_09_ 8_19_51_51.png' => 'Dashboard',
            '0025-EaseUS_2026_09_ 8_19_52_09.png' => 'Elenco segnalazioni',
            '0025-EaseUS_2026_09_ 8_19_52_47.png' => 'Nuova segnalazione',
            '0025-EaseUS_2026_09_ 8_19_52_58.png' => 'Utenti registrati',
        ],
        'date' => '2026-09-20',
        'status' => 'pubblicato',
        'visible' => true,
        'youtube_url' => 'https://youtu.be/NrMsr6bxyvs',
        'sn_frontpage' => 's',
    ],
    [
        'slug' => 'come-organizzare-turni-lavoro-piccola-attivita',
        'file' => 'articles/0003-come-organizzare-turni-lavoro-piccola-attivita.php',
        'title' => 'Come organizzare i turni di lavoro in una piccola attività',
        'seo_title' => 'Organizzare i turni di lavoro',
        'excerpt' => 'Una guida pratica per organizzare i turni di lavoro, gestire assenze e modifiche e capire quando un semplice foglio di calcolo non basta più.',
        'seo_description' => 'Scopri come organizzare i turni di lavoro in una piccola attività, gestire assenze e modifiche e scegliere lo strumento più adatto.',
        'category' => 'Gestionali custom',
        'featured_image' => '/assets/images/0003/0032-dashboard.webp',
        'image_alt' => '',
        'gallery_folder' => '0003',
        'date' => '2026-09-25',
        'status' => 'pubblicato',
        'visible' => true,
        'youtube_url' => '',
        'sn_frontpage' => 'n',
    ],
];

// Helper functions are required here so that every page which loads
// config.php automatically has access to them (e.g. format_article_date()
// used directly inside article files, before layout.php is included).
require_once __DIR__ . '/functions.php';
