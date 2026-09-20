# Helper Class — Guida rapida

Framework di utility class con nomenclatura Bootstrap 5.3. Compilare `helper-class.scss` con `compila.bat` per ottenere `helper-class.css`.

**Breakpoint responsive**: `sm` 576px · `md` 768px · `lg` 992px · `xl` 1200px · `xxl` 1400px
Le classi responsive vanno aggiunte, non sostituite: `.mt-3` (sempre) + `.mt-md-5` (da md in su sovrascrive).

**Tema**: le variabili colore cambiano da sole in base al tema del sistema operativo (`prefers-color-scheme`). Per forzare il tema chiaro a prescindere dal sistema, aggiungi `data-theme="light"` al tag `<html>`.

---

## 1. Spaziature (margin, padding, gap)

Lati: nessuno = tutti i lati, `t` sopra, `b` sotto, `s` sinistra, `e` destra, `x` orizzontale, `y` verticale.
Scala: `0` `1` `2` `3` `4` `5` (da 0 a 3rem) + `auto` (solo margin).

```html
<div class="mt-3 px-4 mb-md-5">...</div>
<!-- margin-top: 1rem; padding orizzontale: 1.5rem; margin-bottom da 768px in su: 3rem -->

<div class="m-auto">Centrato orizzontalmente (con display: block)</div>
```

Gap (flex/grid): `.gap-{0..5}`, `.row-gap-{0..5}`, `.column-gap-{0..5}` — anche responsive (`.gap-lg-4`).

---

## 2. Display

```html
<div class="d-none d-md-block">Nascosto su mobile, visibile da md in su</div>
<div class="d-flex">...</div>
```
Valori: `none` `inline` `inline-block` `block` `grid` `inline-grid` `flex` `inline-flex` `table` `table-cell` `table-row`. Responsive: `.d-{bp}-{valore}`.

---

## 3. Flexbox

```html
<div class="d-flex justify-content-between align-items-center flex-md-column">
  <div class="order-2 order-md-1">B</div>
  <div class="order-1 order-md-2">A</div>
</div>
```

| Classe | Valori |
|---|---|
| `.flex-{valore}` | `row` `column` `row-reverse` `column-reverse` |
| `.flex-{valore}` | `wrap` `nowrap` `wrap-reverse` |
| `.justify-content-{valore}` | `start` `end` `center` `between` `around` `evenly` |
| `.align-items-{valore}` | `start` `end` `center` `baseline` `stretch` |
| `.align-self-{valore}` | `auto` `start` `end` `center` `baseline` `stretch` |
| `.flex-grow-{0\|1}` `.flex-shrink-{0\|1}` | — |
| `.order-{0..5}` | — |

Tutte responsive: `.justify-content-lg-center`, `.order-md-2`, ecc.

---

## 4. Grid

```html
<div class="d-grid grid-cols-3 grid-cols-md-4 gap-3">...</div>

<!-- Colonne automatiche: quante ci stanno, larghezza minima 14rem -->
<div class="d-grid grid-auto-fit-md gap-3">...</div>
```
`.grid-cols-{1..6}` (responsive) — numero di colonne fisso.
`.grid-auto-fit-{sm|md|lg|xl|xxl}` — colonne automatiche, larghezza minima crescente da sm a xxl (10rem → 26rem).

---

## 5. Testo

```html
<p class="text-center text-md-start fw-bold text-truncate">...</p>
```

| Classe | Valori |
|---|---|
| `.text-{valore}` (responsive) | `start` `center` `end` |
| `.fw-{valore}` | `light` (300) `normal` (400) `semibold` (600) `bold` (700) |
| `.fst-italic` / `.fst-normal` | — |
| `.text-decoration-{valore}` | `underline` `line-through` `none` |
| `.text-{valore}` | `lowercase` `uppercase` `capitalize` |
| `.text-truncate` | taglia con `...` su una riga |

---

## 6. Colori (testo, bordo, sfondo)

Colori tema disponibili ovunque: `primary` `secondary` `success` `warning` `danger`.

```html
<p class="text-danger">Testo di errore</p>
<div class="border border-primary">Box con bordo blu</div>
<div class="bg-success">Sfondo verde</div>
<span class="text-bg-warning">Badge con contrasto testo automatico</span>
```

- `.text-{colore}` + `.text-body` (colore testo di default)
- `.border-{colore}` (va combinato con `.border` per essere visibile, vedi sezione 7)
- `.bg-{colore}` (solo sfondo)
- `.text-bg-{colore}` (sfondo + testo già leggibile sopra, comodo per badge/alert)

---

## 7. Bordi e arrotondamenti

```html
<div class="border border-top-0 rounded">...</div>
<div class="border-md">Bordo solo da 768px in su</div>
<img class="rounded-circle" src="avatar.jpg">
```

**Struttura** (responsive, es. `.border-md-top`):
`.border` (tutti i lati) · `.border-top` `.border-bottom` `.border-start` `.border-end` · versione `-0` per rimuovere (es. `.border-end-0`)

**Arrotondamenti** (non responsive):
`.rounded-0` (nessuno) · `.rounded` (normale) · `.rounded-sm` · `.rounded-lg` · `.rounded-circle` · `.rounded-pill`

> Colore del bordo di default: variabile neutra. Per un bordo colorato aggiungi anche `.border-primary`, `.border-danger` ecc. (sezione 6).

---

## 8. Bottoni

```html
<button class="btn btn-primary">Salva</button>
<button class="btn btn-outline-danger">Elimina</button>
<button class="btn btn-secondary" disabled>Non disponibile</button>
```

Serve sempre `.btn` + **un** colore:
- Pieno: `.btn-primary` `.btn-secondary` `.btn-success` `.btn-warning` `.btn-danger`
- Contornato: `.btn-outline-primary` `.btn-outline-secondary` `.btn-outline-success` `.btn-outline-warning` `.btn-outline-danger`

Hover, focus da tastiera e stato disabilitato (`disabled` o classe `.disabled`) sono gestiti automaticamente.

---

## 9. Dimensioni

```html
<div class="w-50 h-100">Metà larghezza, altezza piena del genitore</div>
```
`.w-{25|50|75|100|auto}` · `.h-{25|50|75|100|auto}`

---

## 10. Posizionamento

```html
<div class="position-relative">
  <span class="position-absolute top-0 end-0">Badge in alto a destra</span>
</div>
```
`.position-{static|relative|absolute|fixed|sticky}`
`.top-{0|50|100}` `.bottom-{0|50|100}` `.start-{0|50|100}` `.end-{0|50|100}`

---

## 11. Overflow

`.overflow-{auto|hidden|visible|scroll}`

---

## 12. Opacità

`.opacity-{25|50|75|100}` → 25%, 50%, 75%, 100%

---

## 13. Z-index

`.z-{0|1|2|3}` — utile per sovrapposizioni (es. header sticky sopra il contenuto).

---

## 14. Varie

```html
<div class="cursor-pointer" onclick="...">Cliccami</div>

<a class="visually-hidden-focusable" href="#contenuto">Salta al contenuto</a>
<span class="visually-hidden">Testo solo per screen reader</span>
```
- `.cursor-pointer` — mostra la manina al passaggio del mouse
- `.visually-hidden` — nasconde visivamente ma resta leggibile dagli screen reader
- `.visually-hidden-focusable` — nascosto finché non riceve il focus (es. link "salta al contenuto")

---

## Esempio combinato

```html
<div class="d-flex justify-content-between align-items-center p-3 mb-4 rounded border">
  <span class="fw-bold text-truncate">Titolo lungo che si tronca...</span>
  <button class="btn btn-primary">Azione</button>
</div>
```