<?php

namespace CLL\Exporters\Interfaces;

use CLL\Parsers\CountryList;
use CLL\Parsers\CountryData;

interface TinyCountries
{ 
  public function getCountryListSource() : CountryList;
  public function getCountryDataSource() : CountryData;
  
  public function createDistDir(string $subdir = "") : string;
  public function saveJson(string $file, array &$array);
  public function showFilename(string $file);
}