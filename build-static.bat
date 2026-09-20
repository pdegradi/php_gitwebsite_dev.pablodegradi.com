@echo off
setlocal

rem ============================================================
rem Percorso dell'eseguibile PHP. Modifica questo valore se "php"
rem non e' disponibile nel PATH di sistema, es.:
rem set PHP_EXE=C:\php\php.exe
rem ============================================================
set PHP_EXE=C:\Users\pablo\Desktop\varie\WinMenuApp\zamplite\php-8.5.8\php.exe

"%PHP_EXE%" "%~dp0build-static.php"

echo.
pause