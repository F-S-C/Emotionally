@echo off


IF /I "%1"=="docs" GOTO docs
IF /I "%1"=="serve" GOTO serve
IF /I "%1"=="clean" GOTO clean
IF /I "%1"=="dev-install" GOTO dev-install
GOTO error

:docs
	PUSHD docs && CALL make.bat && POPD
	GOTO :EOF

:serve
	PUSHD src && php artisan serve && POPD
	GOTO :EOF

:clean
	PUSHD docs && CALL make.bat clean && POPD
	GOTO :EOF

:dev-install
	PUSHD src && composer install && POPD
	GOTO :EOF

:error
    IF "%1"=="" (
        ECHO make: *** No targets specified and no makefile found.  Stop.
    ) ELSE (
        ECHO make: *** No rule to make target '%1%'. Stop.
    )
    GOTO :EOF
