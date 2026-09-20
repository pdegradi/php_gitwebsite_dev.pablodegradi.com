# Articoli dei progetti

I file restano in questa cartella con un numero iniziale, così sono ordinati in Esplora file. La cartella delle immagini in `assets/images/` usa lo stesso numero (`0001`, `0002`, ...). Il numero non compare nell’URL pubblico degli articoli.

Per aggiungere un articolo:

1. Crea il prossimo file numerato in `articles/` con il solo contenuto HTML dell'articolo (senza layout).
2. Aggiungi una voce in `$articles` dentro `includes/config.php` con `slug` senza numero, `file`, `title`, `excerpt`, `category`, `date`, `status`, `visible`, `featured_image`, `image_alt` e `gallery_folder`.
3. Imposta `sn_frontpage => 's'` se vuoi mostrare l'articolo anche nella home. Con `n` o un altro valore apparirà solo nella pagina Progetti. `youtube_url` può contenere un link HTTPS a un video YouTube oppure una stringa vuota; quando è compilato, l'articolo mostra una grande anteprima che carica il lettore solo dopo il clic.
4. Finché il contenuto è illustrativo, imposta `status => 'bozza'`. La pagina mostrerà l'avviso, avrà `noindex` e resterà fuori dalla sitemap. Per un articolo definitivo usa `status => 'pubblicato'`.
5. Esegui `build-static.bat` per aggiornare `dist/`. Per la versione PHP, esegui anche `crea_sitemap_robots.php`.

L'indirizzo PHP è `/progetto.php?slug=titolo-del-progetto`; nella build statica diventa `/progetti/titolo-del-progetto.html`. Le immagini degli articoli sono in `assets/images/`.

Per la galleria, crea una cartella in `assets/images/` con il numero dell'articolo e inserisci lo stesso numero in `gallery_folder`. Tutte le immagini JPG, PNG, WebP, GIF, AVIF o SVG presenti direttamente nella cartella compariranno alla fine dell'articolo, ordinate per nome. Per sostituire il nome del file con una didascalia, aggiungi la mappa facoltativa `gallery_captions` (nome del file => testo). Dopo aver aggiunto immagini, esegui di nuovo `build-static.bat` per aggiornare la versione statica.
