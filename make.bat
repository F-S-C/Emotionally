@echo off

if "%1"=="docs" goto docs
if "%1"=="serve" goto serve
goto error

:docs
	pushd docs
    call make.bat
    popd
    goto EOF

:serve
	pushd src
    php artisan serve
    popd
    goto EOF

:error
    if "%1"=="" (
        echo make: *** No targets specified and no makefile found.  Stop.
    ) else (
        echo make: *** No rule to make target '%1%'. Stop.
    )
