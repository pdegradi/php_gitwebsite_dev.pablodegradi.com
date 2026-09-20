<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Siti Web',
    'eyebrow' => 'Presenza online',
    'description' => 'Siti web professionali per professionisti e piccole attività: contenuti chiari, navigazione semplice e attenzione alla SEO di base.',
    'intro' => 'Un sito web dovrebbe spiegare in modo semplice chi sei, cosa fai e perché una persona dovrebbe contattarti.',
    'sections' => [
        ['title' => 'Siti pensati per attività reali', 'text' => 'Realizzo siti vetrina e siti professionali per chi ha bisogno di una presenza online chiara, veloce e facile da mantenere.', 'items' => ['Struttura semplice e navigazione chiara', 'Lettura comoda su telefono e computer', 'Pagine veloci e contenuti comprensibili', 'Attenzione alla SEO di base', 'Facilità di aggiornamento']],
        ['title' => 'Non solo grafica', 'text' => 'Il punto di partenza non è scegliere colori o animazioni, ma capire quale messaggio deve arrivare a chi visita il sito e quale azione vogliamo facilitare.'],
        ['title' => 'Un sito che puoi usare davvero', 'text' => 'Valutiamo insieme quali pagine servono, come organizzare i contenuti e come tenere il sito aggiornato nel tempo senza complicazioni inutili.'],
    ],
    'cta_title' => 'Devi creare o rifare il tuo sito?',
    'cta_text' => 'Scrivimi cosa fai e cosa vorresti comunicare. Partiamo da lì.',
    'cta_label' => 'Parliamone',
];
require __DIR__ . '/includes/layout/service-page.php';
