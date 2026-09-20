<?php
/**
 * includes/db-examples.php
 *
 * Reference examples only. This file is never required by anything in
 * the framework: copy the snippet you need into your own page.
 * Uses get_db_connection() from includes/functions.php, which reads the
 * $db_* variables from config.php.
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

/*

// ---- SELECT (multiple rows) ----------------------------------------
$pdo = get_db_connection();
$stmt = $pdo->prepare('SELECT id, title, published_at FROM posts WHERE status = :status ORDER BY published_at DESC');
$stmt->execute(['status' => 'published']);
$posts = $stmt->fetchAll(); // array of associative arrays


// ---- SELECT (single row) --------------------------------------------
$stmt = $pdo->prepare('SELECT id, title FROM posts WHERE id = :id');
$stmt->execute(['id' => 42]);
$post = $stmt->fetch(); // false if not found


// ---- INSERT + last inserted id ---------------------------------------
$stmt = $pdo->prepare('INSERT INTO posts (title, body, created_at) VALUES (:title, :body, NOW())');
$stmt->execute([
    'title' => 'New post',
    'body'  => 'Post content...',
]);
$newId = $pdo->lastInsertId();


// ---- UPDATE -----------------------------------------------------------
$stmt = $pdo->prepare('UPDATE posts SET title = :title WHERE id = :id');
$stmt->execute([
    'title' => 'Updated title',
    'id'    => 42,
]);
$affectedRows = $stmt->rowCount();


// ---- DELETE -------------------------------------------------------------
$stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
$stmt->execute(['id' => 42]);


// ---- Transaction (begin / commit / rollback) ---------------------------
$pdo = get_db_connection();
try {
    $pdo->beginTransaction();

    $pdo->prepare('UPDATE accounts SET balance = balance - :amount WHERE id = :id')
        ->execute(['amount' => 100, 'id' => 1]);

    $pdo->prepare('UPDATE accounts SET balance = balance + :amount WHERE id = :id')
        ->execute(['amount' => 100, 'id' => 2]);

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e; // or handle/log the error, depending on $app_debug
}

*/
