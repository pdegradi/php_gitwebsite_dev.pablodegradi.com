@echo off
setlocal

REM ============================================================
REM   Percorso assoluto dell'eseguibile sass (Dart Sass).
REM   MODIFICA questo percorso in base a dove l'hai installato.
REM ============================================================
set "SASS_EXE=C:\Users\pablo\Desktop\varie\portable\dart-sass\sass.bat"

REM ============================================================
REM   Cartella di output del css, relativa alla cartella in cui
REM   si trova questo file bat (e il file helper-class.scss).
REM   Di default punta alla cartella "css" affiancata alla
REM   cartella "scss" corrente (..\css). Modificala se vuoi che
REM   il css venga generato altrove.
REM ============================================================
set "OUTPUT_DIR=..\css"

set "SRC_DIR=%~dp0"
set "SRC_FILE=%SRC_DIR%helper-class.scss"
set "OUT_DIR=%SRC_DIR%%OUTPUT_DIR%"
set "OUT_FILE=%OUT_DIR%\helper-class.css"

if not exist "%SASS_EXE%" goto :err_sass
if not exist "%SRC_FILE%" goto :err_src
if not exist "%OUT_DIR%" mkdir "%OUT_DIR%"

echo ================================================
echo   Compilazione helper-class.scss
echo ================================================
echo.
echo Scegli il formato del css generato:
echo   1 = Compresso  (minificato, per produzione)
echo   2 = Leggibile   (indentato, per sviluppo)
echo.
set /p SCELTA="Digita 1 o 2 e premi INVIO: "

if "%SCELTA%"=="1" goto :compresso
if "%SCELTA%"=="2" goto :leggibile

echo.
echo Scelta non valida, uso il formato leggibile di default.
goto :leggibile

:compresso
echo.
echo Compilazione in corso [formato compresso]...
"%SASS_EXE%" --style=compressed --no-source-map "%SRC_FILE%" "%OUT_FILE%"
goto :fine

:leggibile
echo.
echo Compilazione in corso [formato leggibile]...
"%SASS_EXE%" --style=expanded --no-source-map "%SRC_FILE%" "%OUT_FILE%"
goto :fine

:fine
if exist "%OUT_FILE%" (
    echo.
    echo Fatto! File generato:
    echo   "%OUT_FILE%"
) else (
    echo.
    echo [ERRORE] Il file css non e' stato generato. Controlla i messaggi sopra.
)
echo.
echo ================================================
echo Premi un tasto per chiudere questa finestra...
pause>nul
goto :eof

:err_sass
echo [ERRORE] Non trovo l'eseguibile sass in:
echo   "%SASS_EXE%"
echo Apri questo file .bat con un editor di testo e correggi il
echo percorso nella riga "set SASS_EXE=...".
echo.
echo Premi un tasto per chiudere questa finestra...
pause>nul
goto :eof

:err_src
echo [ERRORE] Non trovo il file sorgente "helper-class.scss" nella cartella:
echo   "%SRC_DIR%"
echo.
echo Premi un tasto per chiudere questa finestra...
pause>nul
goto :eof