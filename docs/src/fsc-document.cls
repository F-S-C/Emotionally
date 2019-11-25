\NeedsTeXFormat{LaTeX2e}
\ProvidesClass{fsc-document}[2019/11/11 FSC's document]
\LoadClass[a4paper,twoside,openright,11pt]{book}
\RequirePackage[inner=3.5cm, outer=2.5cm]{geometry}
\RequirePackage{amssymb}
\RequirePackage[utf8]{inputenc}
\RequirePackage[table,xcdraw]{xcolor}
\RequirePackage[explicit]{titlesec}
\RequirePackage{calc}
\RequirePackage{soul}
\RequirePackage{fourier}
\RequirePackage{booktabs}
\RequirePackage{float}
\RequirePackage{wrapfig}
\RequirePackage[labelfont=bf]{caption}
\RequirePackage[labelfont=bf]{subcaption}
\providecommand{\abstract}{}
\RequirePackage{abstract}
\RequirePackage{fancyhdr}
\RequirePackage{hyperref}
\RequirePackage{graphicx}
\RequirePackage{translations}
\DeclareTranslationFallback{the-team}{The team}
\DeclareTranslation{Italian}{the-team}{Il team}
\DeclareTranslation{English}{the-team}{The team}
\newcommand\course[1]{\renewcommand\@course{#1}}
\newcommand\@course{{}}
\newcommand\doctype[1]{\renewcommand\@doctype{#1}}
\newcommand\@doctype{}
\newcommand\license[1]{\renewcommand\@license{#1}}
\newcommand\@license{}

\makeatletter
\def\maketitle{
    \null
    \pagestyle{empty}
    \centering

    \vspace*{0.5 cm}
    \textsc{\large \@course{}}\\[0.5 cm]
    \textsc{\Large \@doctype{}}\\[1 cm]
    % University or Project Logo:
    \includegraphics[height=4cm]{logo.png}\\[0.5 cm]

    \rule{\linewidth}{0.2 mm}\\[0.4 cm]
    % Document Title:
    { \huge \bfseries \textsc{\@title}}\\
    \rule{\linewidth}{0.2 mm}\\[1.5 cm]

    \vfill

    \begin{minipage}{0.4\textwidth}
    \begin{center} \large %originally flushleft
    \textbf{\underline{\GetTranslation{the-team}}}\\
    \@author
    \end{center}
    \end{minipage}~
    %        \begin{minipage}{0.4\textwidth}
    %            \begin{flushright} \large % Your Student Number
    %                \textbf{\underline{Matricole:}} \\
    %                675888\\
    %                676502\\
    %                676964\\
    %                677021\\
    %                677909
    %            \end{flushright}
    %        \end{minipage}
    \\[2 cm]
    % Date or Degree Course:
    {\large \@date}\\[2 cm]

    \clearpage
    \topskip0pt
    \vspace*{\fill}
    \includegraphics[height=0.4\textwidth]{Logo_FSC_WhiteBg.png}\\[0.5cm]
    \textit{\textbf{F.S.C.} --- Five Students of Computer Science}

    \vspace*{5cm}

    \begin{flushleft}
    \begin{minipage}{\textwidth}%0.75
    \begin{quote}
    \@license{}
    \end{quote}
    \end{minipage}
    \end{flushleft}

    \vspace*{\fill}
}
\makeatother

\pagestyle{fancy}
\fancyhf{}
\fancyhead[LE,RO]{\leftmark}
\fancyhead[RE,LO]{\rightmark}
\fancyfoot[CE,CO]{}
\fancyfoot[LE,RO]{\thepage}
\renewcommand{\headrulewidth}{1pt}
  \renewcommand{\footrulewidth}{1pt}

\fancypagestyle{plain}{ %
  \fancyhf{} % remove everything
  \fancyfoot[LE,RO]{\thepage}
  \renewcommand{\headrulewidth}{0pt} % remove lines as well
  \renewcommand{\footrulewidth}{1pt}
}