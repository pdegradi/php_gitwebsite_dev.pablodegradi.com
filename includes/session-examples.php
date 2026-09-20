<?php
/**
 * includes/session-examples.php
 *
 * Reference examples only. This file is never required by anything in
 * the framework: copy the snippet you need into your own page.
 * Uses the session helpers from includes/functions.php ($session_lifetime_minutes
 * comes from config.php).
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

/*

// ---- Start the session (once, at the top of a page that needs it) -----
start_app_session();


// ---- Set / read a normal session value --------------------------------
$_SESSION['cart_items'] = 3;
$count = $_SESSION['cart_items'] ?? 0;


// ---- Login pattern ------------------------------------------------------
// Regenerating the session id on login/privilege change prevents session
// fixation attacks.
function log_user_in(int $userId): void
{
    start_app_session();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
}


// ---- Check whether someone is logged in --------------------------------
start_app_session();
$isLoggedIn = isset($_SESSION['user_id']);


// ---- Logout ---------------------------------------------------------------
function log_user_out(): void
{
    start_app_session();
    $_SESSION = [];
    session_destroy();
}


// ---- Flash messages (read once, then automatically cleared) -----------
// Typical use: set a message before a redirect, read it on the next page.
start_app_session();

flash_set('notice', 'Salvataggio riuscito.');
// ... redirect ...

// On the next page load:
$notice = flash_get('notice'); // returns the message, and clears it
if (flash_has('other_key')) {
    // check without consuming
}

*/
