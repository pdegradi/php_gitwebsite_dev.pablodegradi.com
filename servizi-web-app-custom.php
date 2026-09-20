<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Web App Custom',
    'eyebrow' => 'Sviluppo su misura',
    'description' => 'Web app su misura per gestire clienti, dati e processi specifici. Uno strumento costruito intorno al modo in cui lavori.',
    'intro' => 'Non tutte le attività possono essere gestite bene con software già pronti. Quando un processo è troppo specifico, una web app su misura può diventare lo strumento più semplice per gestirlo.',
    'sections' => [
        ['title' => 'Quando può essere utile', 'text' => 'Una web app può aiutarti quando gli strumenti che usi richiedono troppi passaggi o non seguono il tuo flusso di lavoro.', 'items' => ['Gestire clienti, richieste o pratiche', 'Organizzare dati e documenti', 'Sostituire fogli Excel complessi', 'Creare aree riservate', 'Automatizzare passaggi manuali', 'Costruire strumenti interni specifici']],
        ['title' => 'Come lavoro', 'text' => 'Parto dal problema da risolvere, non dalla tecnologia. Definiamo il flusso principale e le funzioni davvero necessarie, poi costruiamo una soluzione semplice da usare e facile da evolvere.'],
        ['title' => 'Non serve partire da un progetto già definito', 'text' => 'Puoi contattarmi anche se hai soltanto un’esigenza o un processo che oggi gestisci male. La prima fase serve proprio a capire quale soluzione ha senso realizzare.'],
    ],
    'cta_title' => 'Hai un processo che vorresti semplificare?',
    'cta_text' => 'Raccontami come lo gestisci oggi. Possiamo capire insieme da dove iniziare.',
    'cta_label' => 'Parliamone',
];
require __DIR__ . '/includes/layout/service-page.php';
