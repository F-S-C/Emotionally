# <img src="./logo/512x512.png" alt="Emotionally's logo" width="50px"> Emotionally<!-- omit in toc -->

[![License](https://img.shields.io/github/license/F-S-C/Emotionally.svg?style=for-the-badge)](https://github.com/F-S-C/Emotionally/blob/master/LICENSE)
[![Latest release](https://img.shields.io/github/release/F-S-C/Emotionally.svg?style=for-the-badge)](https://github.com/F-S-C/Emotionally/releases)

_Read this in other languages: [Italiano](https://github.com/F-S-C/Emotionally/blob/master/README.it.md)_

**:warning: WARNING:** This project was created as part of a university exam, so (except for this file) it's documented only in *Italian*.

## Table of Contents<!-- omit in toc -->

- [Preface](#preface)
  - [The Authors](#the-authors)
  - [The Exam](#the-exam)
  - [The Repository](#the-repository)
    - [The Structure of this Repository](#the-structure-of-this-repository)
- [Copyright and Licenses](#copyright-and-licenses)
  - [Used Tools and Libraries](#used-tools-and-libraries)

## Preface

### The Authors

_Emotionally_ was created as an exam's project by the group [**_F.S.C. &mdash; Five Students of Computer Science_**](https://github.com/F-S-C), made of:

- [Alessandro **Annese**](https://github.com/Ax3lFernus)
- [Davide **De Salvo**](https://github.com/Davidedes)
- [Andrea **Esposito**](https://github.com/espositoandrea)
- [Graziano **Montanaro**](https://github.com/prewarning)
- [Regina **Zaccaria**](https://github.com/ReginaZaccaria)

The referent of the group for this project is Alessandro **Annese**.

### The Exam

The exam for which this project was created is one of **Web Programming** (in Italian: *"Produzione per il Web", P.P.W.*) of the third year of the Degree Course in _Computer Science and Digital Communication_ of the University of Bari "Aldo Moro".

### The Repository

In this repository there are:

- The system source code
- The documentation
- The documentation source code

Visit the subsection ['the structure of this repository'](#the-structure-of-this-repository) to get more information on the organization of this repository and on the files that are in it.

The documentation source files are in [LaTeX](https://www.latex-project.org/) format (`.tex` extension). The files automatically generated by `pdflatex`, the TeX compiler used to generate the PDF files in the `docs` directory, during the compilation are not included in this repository.

#### The Structure of this Repository

This is the structure of the repository.

```plaintext
Emotionally
├── docs (the documentation of the system)
│   └── src (the documentation source code)
└── src (the source code of the system)
```

## Copyright and Licenses

This project is released under the [**GNU GPL v3 License**](https://www.gnu.org/licenses/quick-guide-gplv3.en.html) (see the [`LICENSE`](https://github.com/F-S-C/Emotionally/blob/master/LICENSE) file for more information). So, any use of the source code requires a copyright notice containing the source of the code and its original authors (as well as the same license). To show the original authors of the code a notation like `F.S.C. (Alessandro Annese, Davide De Salvo, Andrea Esposito, Graziano Montanaro, Regina Zaccaria)` is preferred (it can be used another notation where are shown _both_ the group name _and_ its components).

The documentation of the project is, instead, released under the [**GNU FDL v1.3**](https://www.gnu.org/licenses/fdl-1.3.html) (see the [`LICENSE`](https://github.com/F-S-C/Emotionally/blob/master/docs/LICENSE) file for more information).

### Used Tools and Libraries

The system is built using [Laravel](https://laravel.com/), [jQuery](https://jquery.com/) and [Bootstrap](https://getbootstrap.com/).
