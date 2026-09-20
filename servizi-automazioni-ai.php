<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Automazioni e AI',
    'eyebrow' => 'Meno passaggi manuali',
    'description' => 'Automazioni e integrazioni AI applicate a processi concreti: documenti, contenuti, attività ripetitive e strumenti già in uso.',
    'intro' => 'L’AI può essere utile quando viene inserita in un processo concreto. Serve capire dove può ridurre lavoro manuale o migliorare un’attività.',
    'sections' => [
        ['title' => 'Esempi di utilizzo', 'text' => 'Un’automazione ha senso quando risolve un passaggio preciso del lavoro quotidiano.', 'items' => ['Generare o classificare contenuti', 'Elaborare documenti', 'Automatizzare attività ripetitive', 'Integrare modelli AI in applicazioni esistenti', 'Creare assistenti interni', 'Collegare software tradizionale e AI']],
        ['title' => 'Approccio pratico', 'text' => 'Valuto prima il problema, poi la tecnologia. Se l’AI non serve, non viene utilizzata. L’obiettivo rimane costruire una soluzione utile e sostenibile.'],
        ['title' => 'Partiamo da un’attività concreta', 'text' => 'Descrivimi un compito che richiede tempo o tanti passaggi manuali. Possiamo valutare se e come semplificarlo.'],
    ],
    'cta_title' => 'Vuoi capire se un’attività può essere automatizzata?',
    'cta_text' => 'Raccontami il flusso attuale e vediamo quali passaggi hanno senso.',
    'cta_label' => 'Parliamone',
];
require __DIR__ . '/includes/layout/service-page.php';
