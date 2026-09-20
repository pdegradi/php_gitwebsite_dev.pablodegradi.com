<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Consulenza e Formazione',
    'eyebrow' => 'Supporto pratico',
    'description' => 'Consulenza e formazione pratica su sviluppo web, applicazioni su misura, automazioni e uso concreto dell’AI.',
    'intro' => 'Non sempre serve sviluppare subito qualcosa. A volte è più utile capire prima quale strada prendere, quali strumenti usare o come affrontare un problema tecnico.',
    'sections' => [
        ['title' => 'Consulenza', 'text' => 'Posso aiutarti a valutare soluzioni, strumenti, fattibilità e approcci legati a sviluppo web, applicazioni custom, automazioni e AI.'],
        ['title' => 'Formazione', 'text' => 'Propongo formazione pratica su sviluppo web e utilizzo dell’AI, con un approccio orientato all’uso reale degli strumenti. Il contenuto parte dalle tue esigenze e dal tuo livello di partenza.'],
        ['title' => 'Quando può esserti utile', 'text' => 'Se hai un’idea da valutare, devi scegliere uno strumento o vuoi imparare a gestire meglio una parte del tuo lavoro digitale, possiamo partire da un confronto mirato.'],
    ],
    'cta_title' => 'Hai bisogno di un confronto o di formazione su un tema specifico?',
    'cta_text' => 'Scrivimi qual è il tuo obiettivo e dove ti trovi adesso.',
    'cta_label' => 'Contattami',
];
require __DIR__ . '/includes/layout/service-page.php';
