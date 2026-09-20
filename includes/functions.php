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

/** Encode ASCII mail links in static HTML without changing their browser behavior. */
function email_html_entities(string $value): string
{
    $encoded = '';
    foreach (str_split($value) as $character) {
        $encoded .= '&#' . ord($character) . ';';
    }
    return $encoded;
}

function render_email_link(string $email, ?string $label = null, string $class = '', string $subject = ''): string
{
    $href = 'mailto:' . $email;
    if ($subject !== '') {
        $href .= '?subject=' . rawurlencode($subject);
    }

    $class_attribute = $class === '' ? '' : ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"';
    $text = $label === null
        ? email_html_entities($email)
        : htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

    return '<a' . $class_attribute . ' href="' . email_html_entities($href) . '">' . $text . '</a>';
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

    usort($sorted, function ($a, $b) use ($sort_by, $sort_order) {
        if ($sort_by === 'date') {
            // ISO dates (Y-m-d) sort correctly with a plain string comparison.
            $comparison = strcmp($a['date'] ?? '', $b['date'] ?? '');
        } else {
            $comparison = strcasecmp($a['title'] ?? '', $b['title'] ?? '');
        }
        return $sort_order === 'desc' ? -$comparison : $comparison;
    });

    return $sorted;
}

/** Public project articles only. */
function get_public_articles(array $articles, string $sort_by = 'date', string $sort_order = 'desc'): array
{
    $public = array_values(array_filter($articles, static fn ($article) => !empty($article['visible'])));
    return get_sorted_articles($public, $sort_by, $sort_order);
}

function project_url(array $article): string
{
    return '/progetto.php?slug=' . rawurlencode($article['slug']);
}

function render_project_cards(array $articles): string
{
    if ($articles === []) {
        return '<p>I nuovi progetti saranno pubblicati qui.</p>';
    }

    ob_start();
    ?>
    <div class="project-grid">
        <?php foreach ($articles as $article): ?>
            <article class="project-card">
                <div class="project-card__visual">
                    <?php if (!empty($article['featured_image'])): ?>
                        <img src="<?= htmlspecialchars($article['featured_image'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($article['image_alt'] ?? $article['title'], ENT_QUOTES) ?>" loading="lazy">
                    <?php endif; ?>
                    <span><?= htmlspecialchars($article['category'] ?? 'Progetto') ?></span>
                </div>
                <div class="project-card__body">
                    <?php if (!empty($article['date'])): ?><time class="project-card__meta" datetime="<?= htmlspecialchars($article['date'], ENT_QUOTES) ?>"><?= htmlspecialchars(format_article_date($article['date'])) ?></time><?php endif; ?>
                    <h3><a href="<?= htmlspecialchars(project_url($article), ENT_QUOTES) ?>"><?= htmlspecialchars($article['title']) ?></a></h3>
                    <p><?= htmlspecialchars($article['excerpt'] ?? '') ?></p>
                    <a class="text-link" href="<?= htmlspecialchars(project_url($article), ENT_QUOTES) ?>">Leggi il progetto</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
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
