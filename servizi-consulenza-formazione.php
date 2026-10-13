<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Consulenza e Formazione',
    'eyebrow' => 'Supporto tecnico',
    'description' => 'Consulenza tecnica e formazione sullo sviluppo web per valutare la fattibilità di un progetto e scegliere un percorso concreto.',
    'intro' => 'Un confronto tecnico per professionisti e piccole attività che devono valutare un progetto web e vogliono ottenere indicazioni chiare su fattibilità, priorità e possibili scelte.',
    'sections' => [
        [
            'title' => 'Consulenza tecnica',
            'text' => 'Posso aiutarti a mettere a fuoco requisiti, vincoli e alternative per siti web, applicazioni custom e integrazioni tra sistemi.',
        ],
        [
            'title' => 'Valutazione di fattibilità',
            'text' => 'Analizziamo l’idea, il processo da supportare e le dipendenze tecniche per capire quali parti siano realizzabili e quali decisioni servano prima di procedere.',
        ],
        [
            'title' => 'Formazione sullo sviluppo web',
            'text' => 'La formazione parte dal tuo livello e da un obiettivo concreto, con spiegazioni ed esercitazioni dedicate allo sviluppo e alla gestione di soluzioni web.',
        ],
        [
            'title' => 'Quando può esserti utile',
            'text' => 'È pensata per chi deve prendere una decisione tecnica o acquisire competenze operative e vuole ottenere una valutazione motivata e un percorso di lavoro comprensibile.',
        ],
    ],
    'cta_title' => 'Hai bisogno di un confronto su un progetto web?',
    'cta_text' => 'Descrivi l’idea, il dubbio tecnico o l’obiettivo formativo da cui vuoi partire.',
    'cta_label' => 'Compila il modulo',
];
require __DIR__ . '/includes/layout/service-page.php';