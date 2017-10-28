# Countries - Languages - Locales

## Warning

**This code is NOT intended directly for use in production environment. Instead you should install it and run locally and use the output for your production.**

## Why

There is a couple of great open data sets on the web. So, why to use this tool instead of data sets directly? Well, when we were looking for data sets that would suit for purposes of our project [Ukey1](https://ukey.one), we've found out that no source was as we needed: **lightweight and with a custom structure**.  When you are in a similar situation, our tool can help you. Just choose from predefined output formats or make your own `Exporter` extension.

## Installation

* Clone this repository to your localhost
* Install dependencies:
    * PHP 7.1+
    * [Composer](https://getcomposer.org/download/)
* Run `composer install`
* Run `./install.sh` to download (or update) data sets
* Run `./run.sh` and follow instructions

## Formats

All available datasets are already exported in [dist/](dist/) directory.

### List of countries

#### TinyCountries --ds-multi-locale-alpha2

JSON list of countries with [ISO 3166-1 alpha 2](http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) codes and localized names. All localized files are named as `xx_XX-countries.json` (where `xx` is a ISO 639-1 code and `XX` is a ISO 3166-1 code). The structure of JSON is: array of objects `{"code": "<code>", "name": "<name>"}`.

#### TinyCountries --ds-multi-locale-alpha3

JSON list of countries with [ISO 3166-1 alpha 3](http://en.wikipedia.org/wiki/ISO_3166-1_alpha-3) codes and localized names. All localized files are named as `xx_XX-countries.json` (where `xx` is a ISO 639-1 code and `XX` is a ISO 3166-1 code). The structure of JSON is: array of objects `{"code": "<code>", "name": "<name>"}`.

### List of languages

#### TinyLanguages --ds-multi-locale-alpha2

JSON list of languages with [ISO 639-1](http://en.wikipedia.org/wiki/ISO_639-1) codes and localized names. All localized files are named as `xx_XX-languages.json` (where `xx` is a ISO 639-1 code and `XX` is a ISO 3166-1 code). The structure of JSON is: array of objects `{"code": "<code>", "name": "<name>"}`.

#### TinyLanguages --ds-multi-locale-locale

JSON list of languages with "Locale" codes (in the format `xx_XX` where `xx` is a ISO 639-1 code and `XX` is a ISO 3166-1 code) and localized names. All localized files are named as `xx_XX-languages.json` (where `xx` is a ISO 639-1 code and `XX` is a ISO 3166-1 code). The structure of JSON is: array of objects `{"code": "<code>", "name": "<name>"}`.

## Sources

### Github projects

* [umpirsky/locale-list](https://github.com/umpirsky/locale-list)
* [umpirsky/country-list](https://github.com/umpirsky/country-list)
* [mledoze/countries](https://github.com/mledoze/countries)
* [OpenBookPrices/country-data](https://github.com/OpenBookPrices/country-data)

### Other sources

* `language-codes-3b2` from [datahub.io](https://datahub.io/core/language-codes)
* `continent.json` from [country.io](http://country.io/data/)

## Contribution

When you make a new `Exporter` or `Parser` extension, feel free to share it with others - create a pull request. ;)

## Issues

**Please note** that this tool doesn't contain any data sets. Any issues with data sets themselves should be targeted to that respective projects. Any other issues or tasks are appreciated, of course.

## License

This code is released under the MIT license.