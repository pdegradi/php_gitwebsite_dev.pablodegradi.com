@echo off
setlocal

rem ============================================================
rem Percorso dell'eseguibile PHP. Modifica questo valore se "php"
rem non e' disponibile nel PATH di sistema, es.:
rem set PHP_EXE=C:\php\php.exe
rem ============================================================
set PHP_EXE=C:\Users\pablo\Desktop\varie\WinMenuApp\wampserver\php8.5.10\php.exe

"%PHP_EXE%" "%~dp0build-static.php"

exit /b %ERRORLEVEL%
