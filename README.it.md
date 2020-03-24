# <img src="./logo/512x512.png" alt="Logo di Emotionally" width="50px"> Emotionally<!-- omit in toc -->

[![Licenza](https://img.shields.io/github/license/F-S-C/Emotionally.svg?style=for-the-badge)](https://github.com/F-S-C/Emotionallly/blob/master/LICENSE)
[![Ultima release](https://img.shields.io/github/release/F-S-C/Emotionally.svg?style=for-the-badge)](https://github.com/F-S-C/Emotionally/releases)

_Leggi questo file in altre lingue:
[English](https://github.com/F-S-C/Emotionally/blob/master/README.md)_

**:warning: ATTENZIONE:** Questo progetto è stato creato in vista di un esame
universitario, per questo motivo è documentato solo in *italiano* (fatta
eccezione per la [wiki](https://github.com/F-S-C/Emotionally/wiki)).

## Indice<!-- omit in toc -->

- [Prefazione](#prefazione)
  - [Gli autori](#gli-autori)
  - [L'esame](#lesame)
  - [La repository](#la-repository)
    - [La struttura della repository](#la-struttura-della-repository)
- [Copyright e licenze](#copyright-e-licenze)
  - [I tools e le librerie utilizate](#i-tools-e-le-librerie-utilizate)

## Prefazione

<!-- TODO: Write -->

### Gli autori

_Emotionally_ è stato creato come progetto d'esame dal gruppo [**_F.S.C. &mdash;
Five Students of Computer Science_**](https://github.com/F-S-C), che è composto
da:

- [Alessandro **Annese**](https://github.com/Ax3lFernus)
- [Davide **De Salvo**](https://github.com/Davidedes)
- [Andrea **Esposito**](https://github.com/espositoandrea)
- [Graziano **Montanaro**](https://github.com/prewarning)
- [Regina **Zaccaria**](https://github.com/ReginaZaccaria)

Il referente del gruppo per questo progetto è Alessandro **Annese**.

### L'esame

L'esame per cui questo progetto è stato creato è quello di **_Produzione per il
Web_** (_P.P.W._) del terzo anno del Corso di Laurea in _Informatica e
Comunicazione Digitale_ dell'Università degli Studi di Bari "Aldo Moro".

### La repository

All'interno della _repository_ sono presenti:

- I sorgenti del sistema
- La documentazione
- I sorgenti della documentazione

Ci si riferisca alla sottosezione ['la struttura della
repository'](#la-struttura-della-repository) per maggiori informazioni
sull'organizzaione della repository e dei file in essa presenti.

I sorgenti della documentazione sono in formato
[LaTeX](https://www.latex-project.org/) (estensione `.tex`). Non sono presenti
all'interno della repository i file intermedi che sono automaticamente generati
durante la compilazione da `pdflatex`, il compilatore TeX utilizzato per
generare i file PDF presenti all'interno della directory `docs`.

#### La struttura della repository

La repository è strutturata nel seguente modo.

```plaintext
Emotionally
├── docs (contiene tutta la documentazione del sistema)
│   └── src (contiene i sorgenti della documentazione)
└── src (contiene il codice sorgente del sistema)
```

## Copyright e licenze

Il progetto è rilasciato sotto la [**GNU GPL v3
License**](https://www.gnu.org/licenses/quick-guide-gplv3.en.html) (si veda il
file [`LICENSE`](https://github.com/F-S-C/Emotionally/blob/master/LICENSE) per
maggiori informazioni). Qualsiasi utilizzo del codice sorgente richiede, quindi,
una nota di copyright in cui si specifica la provenienza del codice e i loro
autori (oltre a mantenere la stessa licenza). È preferibile utilizzare, per
indicare gli autori, la seguente notazione: `F.S.C. (Alessandro Annese, Davide
De Salvo, Andrea Esposito, Graziano Montanaro, Regina Zaccaria)` o una notazione
simile (in cui viene presentato il nome del gruppo _e_ i nomi dei suoi
componenti).

La documentazione del progetto è, invece, rilasciata sotto la [**GNU FDL
v1.3**](https://www.gnu.org/licenses/fdl-1.3.html) (vedi il file
[`LICENSE`](https://github.com/F-S-C/Emotionally/blob/master/docs/LICENSE) per
maggiori informazioni).

### I tools e le librerie utilizate

Il sistema è realizzato utilizzando [Laravel](https://laravel.com/), [jQuery](https://jquery.com/) e [Bootstrap](https://getbootstrap.com/).

Il motore di AI utilizzato per il riconoscimento delle emozioni è
[Affectiva](https://www.affectiva.com/), utilizzato mediante il suo [SDK
JavaScript](https://github.com/Affectiva/js-sdk-sample-apps) (rilasciato sotto
la [licenza MIT](https://github.com/Affectiva/js-sdk-sample-apps/blob/master/LICENSE)).
