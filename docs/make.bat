@echo off

set SOURCE_DIR=.\src
set BASEFILENAME=Emotionally

if "%1"=="pdf" goto pdf
if "%1"=="html" goto html
if "%1"=="clean" goto clean
if "%1"=="" goto all
goto error

REM .PHONY: pdf html clean

REM all: pdf clean

:all
set ALL=true
goto :pdf

:pdf
pushd "%SOURCE_DIR%"
pdflatex "%BASEFILENAME%.tex" -synctex=1 -interaction=batchmode --shell-escape
biber "%BASEFILENAME%"
pdflatex "%BASEFILENAME%.tex" -synctex=1 -interaction=batchmode --shell-escape
pdflatex "%BASEFILENAME%.tex" -synctex=1 -interaction=batchmode --shell-escape
xcopy "%BASEFILENAME%.pdf" .. /Y
popd
if "%ALL%"=="true" goto html
goto end

:html
pushd "%SOURCE_DIR%"
pandoc "%BASEFILENAME%.tex" -f latex -t html -s -o "%BASEFILENAME%.html"
xcopy "%BASEFILENAME%.html" .. /Y
popd
if "%ALL%"=="true" goto clean
goto end

:clean
pushd "%SOURCE_DIR%"
del /Q /F *.bcf *.run.xml *.aux *.glo *.idx *.log *.toc *.ist *.acn *.acr *.alg *.bbl *.blg *.dvi *.glg *.gls *.ilg *.ind *.lof *.lot *.maf *.mtc *.mtc1 *.out *.synctex.gz "*.synctex(busy)" *.thm
popd
goto end

:error
echo make: *** No rule to make target '%1%'. Stop.

:end
