<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$service = [
    'title' => 'AI per la tua attività',
    'eyebrow' => 'Lavorare meglio con l’AI',
    'description' => 'AI per la tua attività: consulenza, formazione pratica, integrazioni e automazioni applicate al lavoro quotidiano.',
    'intro' => 'Valutiamo dove l’AI può rendere più semplice il lavoro quotidiano, aiutandoti a organizzare informazioni, preparare contenuti e ridurre passaggi ripetitivi.',
    'sections' => [
        [
            'title' => 'Per chi è e per chi non è',
            'text' => 'È un servizio per professionisti e piccole attività che vogliono capire come usare l’AI su compiti concreti. Non è adatto a chi cerca una soluzione automatica senza rivedere il proprio processo o senza controllare i risultati.',
            'items' => [
                'Per chi vuole partire da attività reali e circoscritte',
                'Per chi vuole imparare a valutare gli output in modo critico',
                'Non per delegare decisioni delicate senza controllo umano',
                'Non per trattare dati riservati senza averne valutato l’uso',
            ],
        ],
        [
            'title' => 'Aree di lavoro',
            'text' => 'L’attenzione è sulle attività da migliorare, prima che sugli strumenti.',
            'items' => [
                'Organizzare, confrontare e sintetizzare informazioni',
                'Preparare bozze di testi e materiali di lavoro',
                'Classificare richieste, documenti o contenuti',
                'Consultare più facilmente procedure e conoscenze interne',
                'Ridurre passaggi ripetitivi nei flussi operativi',
            ],
        ],
        [
            'title' => 'Consulenza e formazione pratica',
            'text' => 'Posso aiutarti a individuare gli usi sensati dell’AI e a costruire un metodo di lavoro pratico: formulare richieste chiare, verificare le risposte e riconoscere i casi in cui serve il giudizio di una persona.',
        ],
        [
            'title' => 'Integrazioni e automazioni dove servono',
            'text' => 'Quando un’attività ricorrente è ben definita, possiamo valutare se collegare l’AI agli strumenti esistenti o inserirla in una web app. L’integrazione viene proposta solo se semplifica davvero il flusso.',
        ],
        [
            'title' => 'Come funziona',
            'text' => 'Il percorso viene costruito sul contesto e sulle attività da affrontare.',
            'items' => [
                'Primo contatto per descrivere l’obiettivo',
                'Conversazione sul modo in cui lavori oggi',
                'Analisi delle attività e dei dati coinvolti',
                'Proposta di un percorso pratico',
                'Affiancamento oppure realizzazione della soluzione concordata',
            ],
        ],
        [
            'title' => 'Uso prudente dei dati',
            'text' => 'Prima di usare un servizio di AI conviene capire quali informazioni vengono inviate e chi può trattarle. Evita di inserire dati personali, credenziali, documenti riservati o informazioni dei clienti se non hai verificato che il servizio e la configurazione siano adatti al tuo caso.',
            'items' => [
                'Rimuovere i dati identificativi quando non sono necessari',
                'Controllare impostazioni, condizioni d’uso e gestione dei dati',
                'Verificare sempre gli output prima di utilizzarli',
                'Mantenere il controllo umano sulle decisioni importanti',
            ],
        ],
    ],
    'faqs' => [
        ['question' => 'Devo sapere già quale strumento usare?', 'answer' => 'No. Partiamo dall’attività che vuoi migliorare e valutiamo solo dopo quali strumenti siano adatti.'],
        ['question' => 'L’AI può automatizzare tutto il processo?', 'answer' => 'Non sempre è opportuno. Alcuni passaggi possono essere assistiti o automatizzati, mentre altri richiedono verifica e decisione umana.'],
        ['question' => 'Posso usare l’AI con i documenti della mia attività?', 'answer' => 'Dipende dal contenuto, dal servizio utilizzato e dalle sue impostazioni. Prima bisogna distinguere i documenti ordinari da quelli che contengono dati personali o riservati.'],
        ['question' => 'La formazione è teorica o pratica?', 'answer' => 'È orientata alle attività quotidiane: si lavora su casi d’uso, modalità di richiesta, controllo delle risposte e limiti da considerare.'],
        ['question' => 'Puoi integrare l’AI in un’applicazione esistente?', 'answer' => 'È possibile quando l’applicazione offre modalità di integrazione compatibili e il caso d’uso è sufficientemente definito. La fattibilità va analizzata.'],
        ['question' => 'Come capisco se l’AI è davvero utile?', 'answer' => 'Osserviamo il processo attuale, i passaggi ripetitivi, i dati disponibili e il livello di controllo necessario. Se non porta un vantaggio concreto, non viene proposta.'],
    ],
    'cta_title' => 'Vuoi capire come usare l’AI nella tua attività?',
    'cta_text' => 'Raccontami un’attività che vorresti rendere più semplice o gestire con maggiore continuità.',
    'cta_label' => 'Compila il modulo',
];
require __DIR__ . '/includes/layout/service-page.php';