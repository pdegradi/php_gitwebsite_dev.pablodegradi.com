<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'Gestionali custom',
    'eyebrow' => 'Sviluppo su misura',
    'description' => 'Gestionali custom per organizzare processi, dati e attività con uno strumento costruito sul modo in cui lavori.',
    'intro' => 'Un gestionale custom segue il tuo modo di lavorare e riunisce dati, attività e passaggi che i software standard gestiscono con difficoltà.',
    'sections' => [
        [
            'title' => 'Quando può essere utile',
            'text' => 'Una web app su misura può aiutarti quando gli strumenti che usi richiedono troppi passaggi o non seguono il tuo flusso di lavoro.',
            'items' => [
                'Gestire clienti, richieste o pratiche',
                'Organizzare dati e documenti',
                'Sostituire fogli di calcolo diventati complessi',
                'Creare aree riservate',
                'Ridurre passaggi manuali',
                'Costruire strumenti interni specifici',
            ],
        ],
        [
            'title' => 'Come lavoro',
            'text' => 'Parto dal problema da risolvere, non dalla tecnologia. Definiamo il flusso principale e le funzioni davvero necessarie, poi costruiamo una soluzione semplice da usare e adatta a evolvere.',
        ],
        [
            'title' => 'Non serve partire da un progetto già definito',
            'text' => 'Puoi contattarmi anche se hai soltanto un’esigenza o un processo che oggi gestisci male. Il confronto iniziale serve a capire quale soluzione abbia senso valutare.',
        ],
        [
            'title' => 'Come funziona',
            'text' => 'Il percorso parte dal lavoro reale e procede per decisioni verificabili.',
            'items' => [
                'Primo contatto per descrivere l’esigenza',
                'Analisi del processo attuale e dei punti critici',
                'Definizione delle funzioni necessarie',
                'Progettazione e realizzazione della soluzione',
                'Consegna e indicazioni per l’utilizzo',
            ],
        ],
    ],
    'projects_title' => 'Guarda i prototipi dimostrativi',
    'projects_text' => 'Nella pagina Progetti trovi esempi di gestionali e web app costruiti per mostrare come può essere organizzato un processo specifico.',
    'faqs' => [
        ['question' => 'Che differenza c’è tra un gestionale custom e un software già pronto?', 'answer' => 'Un software pronto propone un flusso comune a molte attività. Un gestionale custom viene progettato intorno ai passaggi, ai dati e alle regole del tuo lavoro.'],
        ['question' => 'Devo avere già definito tutte le funzioni?', 'answer' => 'No. Puoi partire da un problema concreto o da un processo che oggi richiede troppi passaggi. Le funzioni vengono chiarite durante l’analisi.'],
        ['question' => 'È possibile collegarlo agli strumenti che uso già?', 'answer' => 'Dipende dagli strumenti e dalle modalità di integrazione disponibili. La fattibilità viene valutata prima di proporre il collegamento.'],
        ['question' => 'Il gestionale può essere usato da telefono?', 'answer' => 'Può essere progettato per funzionare dal browser su telefono e computer, in base alle attività che devono essere svolte.'],
        ['question' => 'Posso iniziare da una parte del processo?', 'answer' => 'Sì. Quando ha senso, si può definire un primo ambito utile e lasciare spazio a sviluppi successivi.'],
    ],
    'cta_title' => 'Hai un processo che vorresti semplificare?',
    'cta_text' => 'Raccontami come lo gestisci oggi. Possiamo capire insieme da dove iniziare.',
    'cta_label' => 'Compila il modulo',
];
require __DIR__ . '/includes/layout/service-page.php';