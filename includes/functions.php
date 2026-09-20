<?php
/**
 * includes/functions.php
 * Framework helper functions. Internal file, not meant to be requested directly.
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

//******************************************************************************/
// Gneric funciont 
//******************************************************************************/

function dd($variable, $booldie = true)
{
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
    if($booldie)
        die();
}


/**
 * funzione che uso all'interno degli articoli per tirar fuori tutte le info dell'articolo scelto
 */
function get_current_article_data(array $articles) {
    // 1. Recupera lo slug dal file corrente
    $file_php = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);
    
    // 2. Estrai gli slug e cerca la corrispondenza
    $arr_files = array_column($articles, 'slug');
    $index = array_search($file_php, $arr_files);
    
    // 3. Gestione errore 404 se non viene trovato
    if ($index === false) {
        http_response_code(404);
        echo "<h1>Errore 404 - Articolo non trovato</h1>";
        exit;
    }
    
    // 4. Restituisce un array con i 3 valori che ti servono
    return [
        'title'          => $articles[$index]["title"],
        'date'           => $articles[$index]["date"],
        'featured_image' => $articles[$index]["featured_image"]
    ];
}


/**
 * Returns the article list sorted by title or by publish date.
 * Does not mutate the original array.
 *
 * @param array  $articles  the article registry from config.php
 * @param string $sort_by   'title' or 'date'
 * @param string $sort_order 'asc' or 'desc'
 */
function get_sorted_articles(array $articles, string $sort_by = 'title', string $sort_order = 'asc'): array
{
    $sorted = $articles;

    usort($sorted, function ($a, $b) use ($sort_by) {
        if ($sort_by === 'date') {
            // ISO dates (Y-m-d) sort correctly with a plain string comparison.
            return strcmp($a['date'] ?? '', $b['date'] ?? '');
        }
        return strcasecmp($a['title'] ?? '', $b['title'] ?? '');
    });

    if ($sort_order === 'desc') {
        $sorted = array_reverse($sorted);
    }

    return $sorted;
}

/**
 * Renders optional SEO meta tags from an associative array.
 * Every key is optional: a tag is only output if the corresponding
 * key is present and non-empty. If $seo is empty, nothing is rendered.
 *
 * Recognized keys:
 *   description, keywords, robots, canonical,
 *   og_title, og_description, og_image, og_type, twitter_card
 */
function render_seo_tags(array $seo): string
{
    $name_tags = [
        'description'  => 'description',
        'keywords'     => 'keywords',
        'robots'       => 'robots',
        'twitter_card' => 'twitter:card',
    ];

    $property_tags = [
        'og_title'       => 'og:title',
        'og_description' => 'og:description',
        'og_image'       => 'og:image',
        'og_type'        => 'og:type',
    ];

    $html = '';

    foreach ($name_tags as $var => $metaName) {
        if (!empty($seo[$var])) {
            $html .= '    <meta name="' . htmlspecialchars($metaName) . '" content="' . htmlspecialchars($seo[$var]) . '">' . "\n";
        }
    }

    foreach ($property_tags as $var => $metaProperty) {
        if (!empty($seo[$var])) {
            $html .= '    <meta property="' . htmlspecialchars($metaProperty) . '" content="' . htmlspecialchars($seo[$var]) . '">' . "\n";
        }
    }

    if (!empty($seo['canonical'])) {
        $html .= '    <link rel="canonical" href="' . htmlspecialchars($seo['canonical']) . '">' . "\n";
    }

    return $html;
}

/**
 * Formats an ISO date (Y-m-d) into a human-readable Italian date,
 * e.g. "2026-02-10" -> "10 febbraio 2026".
 * Falls back to the raw string if it cannot be parsed.
 */
function format_article_date(string $isoDate): string
{
    $timestamp = strtotime($isoDate);
    if ($timestamp === false) {
        return $isoDate;
    }

    $months = [
        1 => 'gennaio', 2 => 'febbraio', 3 => 'marzo', 4 => 'aprile',
        5 => 'maggio', 6 => 'giugno', 7 => 'luglio', 8 => 'agosto',
        9 => 'settembre', 10 => 'ottobre', 11 => 'novembre', 12 => 'dicembre',
    ];

    $day   = (int) date('j', $timestamp);
    $month = $months[(int) date('n', $timestamp)];
    $year  = date('Y', $timestamp);

    return "{$day} {$month} {$year}";
}



//******************************************************************************/
// Database functions
//******************************************************************************/
/**
 * Returns a shared PDO connection to the MariaDB database, opening it
 * on first call and reusing it afterwards. Requires $db_host, $db_port,
 * $db_name, $db_user, $db_pass, $db_charset from config.php.
 * Error visibility follows $app_debug (see config.php): PDO always
 * throws exceptions, it's display_errors/log_errors that decide
 * whether they end up on screen or only in the log.
 */
function get_db_connection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        global $db_host, $db_port, $db_name, $db_user, $db_pass, $db_charset;

        $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$db_charset}";
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    return $pdo;
}


//******************************************************************************/
// Sessiones functions
//******************************************************************************/
/**
 * Starts the session (if not already active), applying the lifetime
 * configured in $session_lifetime_minutes (config.php). Safe to call
 * more than once.
 */
function start_app_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    global $session_lifetime_minutes;

    $lifetimeSeconds = (int) $session_lifetime_minutes * 60;
    session_set_cookie_params($lifetimeSeconds);
    ini_set('session.gc_maxlifetime', (string) $lifetimeSeconds);
    session_start();
}

/**
 * Sets a "flash" session value: meant to be read once (e.g. a
 * confirmation or error message to show right after a redirect), then
 * automatically forgotten. Call start_app_session() first.
 */
function flash_set(string $key, $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

/**
 * Reads a flash value and immediately clears it, so a page refresh
 * won't show it again. Returns $default if it was never set.
 */
function flash_get(string $key, $default = null)
{
    if (!isset($_SESSION['_flash'][$key])) {
        return $default;
    }

    $value = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);

    return $value;
}

/**
 * Checks whether a flash value is currently set, without consuming it.
 */
function flash_has(string $key): bool
{
    return isset($_SESSION['_flash'][$key]);
}

