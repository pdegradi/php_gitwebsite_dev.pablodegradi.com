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

$site_name        = "Pablo Dev";
$site_description = "Sviluppo Software Web & AI Integration";
$site_lang        = "it";

// email
$email            = "dev@pablodegradi.com";


/**
 * Article sorting, used by blog.php.
 * $article_sort_by:    'title' or 'date'
 * $article_sort_order: 'asc' or 'desc'
 */
$article_sort_by    = 'date';
$article_sort_order = 'desc';

// Number of articles shown per page on blog.php.
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
//'file'  => 'articles/0013-docker-su-linux-e-primi-comandi.php',
$articles = [
    [
        'slug'  => '0001-windows-subsystem-of-linux-in-windows-11',
        'title' => 'Windows Subsystem of Linux in Windows 11',
        'date'  => '2026-05-26',
        'featured_image'  => '/assets/images/0001/devblog_win11-wsl.webp',
    ],
    [
        'slug'  => '0002-aggiungere-password-a-bitlocker',
        'title' => 'Aggiungere password a Bitlocker',
        'date'  => '2026-05-27',
        'featured_image'  => '/assets/images/0002/devblog_win11bitlocker.webp',
    ],
    [
        'slug'  => '0003-server-lamp-su-ubuntu-24-04-e-debian-13',
        'title' => 'Server Lamp su Ubuntu 24.04 e Debian 13',
        'date'  => '2026-05-28',
        'featured_image'  => '/assets/images/0003/fimage.webp',
    ],
    [
        'slug'  => '0004-ambiente-di-sviluppo-php-con-podman-su-windows-11',
        'title' => 'Ambiente di sviluppo PHP con Podman su Windows 11',
        'date'  => '2026-05-29',
        'featured_image'  => '/assets/images/0004/devblog_win11_podman.webp',
    ],
    [
        'slug'  => '0005-server-lamp-su-alma-linux-rocky-linux-oracle-linux-10',
        'title' => 'Server Lamp su Alma Linux, Rocky Linux, Oracle Linux 10',
        'date'  => '2026-06-01',
        'featured_image'  => '/assets/images/0005/fimage.webp',
    ],
    [
        'slug'  => '0006-come-configurare-ssh-per-gestire-due-account-github-sullo-stesso-computer',
        'title' => 'Come configurare SSH per gestire due account GitHub sullo stesso computer',
        'date'  => '2026-06-02',
        'featured_image'  => '/assets/images/0006/fimage.webp',
    ],
    [
        'slug'  => '0007-come-migrare-un-sito-wordpress-da-hosting-online-a-locale-guida-pratica-completa',
        'title' => 'Come Migrare un Sito WordPress da Hosting Online a Locale: Guida Pratica Completa',
        'date'  => '2026-06-03',
        'featured_image'  => '/assets/images/0007/fimage.webp',
    ],
    [
        'slug'  => '0008-compilare-python-da-sorgente-su-linux-guida-per-rhel-e-debian-ubuntu',
        'title' => 'Compilare Python da sorgente su Linux: guida per RHEL e Debian/Ubuntu',
        'date'  => '2026-06-04',
        'featured_image'  => '/assets/images/0008/fimage.webp',
    ],
    [
        'slug'  => '0009-agenti-ai-guida-a-opencode-pi-coding-agent-e-kilo-code-cli',
        'title' => 'Agenti AI: Guida a OpenCode, Pi Coding Agent e Kilo Code CLI',
        'date'  => '2026-06-05',
        'featured_image'  => '/assets/images/0009/fimage.webp',
    ],
    [
        'slug'  => '0010-compilare-un-ambiente-lamp-da-sorgente-su-linux-rhel-e-debian-ubuntu',
        'title' => 'Compilare un ambiente LAMP da sorgente su Linux (RHEL e Debian/Ubuntu)',
        'date'  => '2026-06-06',
        'featured_image'  => '/assets/images/0010/fimage.webp',
    ],
    [
        'slug'  => '0011-condividere-cartelle-su-linux-con-samba-guida-pratica',
        'title' => 'Condividere cartelle su Linux con Samba: guida pratica',
        'date'  => '2026-06-07',
        'featured_image'  => '/assets/images/0011/fimage.webp',
    ],
    [
        'slug'  => '0012-gpg-su-linux-e-windows-guida-pratica-per-cifrare-file-e-gestire-chiavi',
        'title' => 'GPG su Linux e Windows: Guida Pratica per Cifrare File e Gestire Chiavi',
        'date'  => '2026-06-08',
        'featured_image'  => '/assets/images/0012/fimage.webp',
    ],
    [
        'slug'  => '0013-docker-su-linux-e-primi-comandi',
        'title' => 'Docker su Linux e primi comandi',
        'date'  => '2026-06-09',
        'featured_image'  => '/assets/images/0013/fimage.webp',
    ],
    [
        'slug'  => '0014-docker-sandboxes-guida-pratica-per-eseguire-agenti-ai',
        'title' => 'Docker Sandboxes: la guida pratica per eseguire agenti AI in isolamento con sbx',
        'date'  => '2026-07-14',
        'featured_image'  => '/assets/images/0014/fimage.webp',
    ],
    [
        'slug'  => '0015-winget-windows-11-guida-comandi-per-installare-software',
        'title' => 'Winget su Windows 11: guida pratica ai comandi per installare e aggiornare software',
        'date'  => '2026-07-23',
        'featured_image'  => '/assets/images/0015/fimage.webp',
    ],
];

// Helper functions are required here so that every page which loads
// config.php automatically has access to them (e.g. format_article_date()
// used directly inside article files, before layout.php is included).
require_once __DIR__ . '/functions.php';
