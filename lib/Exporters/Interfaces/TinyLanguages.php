<?php

namespace CLL\Exporters\Interfaces;

use CLL\Parsers\LocaleList;
use CLL\Parsers\LanguageCodes3b2;

interface TinyLanguages
{ 
  public function getLocaleListSource() : LocaleList;
  public function getLanguageCodes3b2Source() : LanguageCodes3b2;
  
  public function createDistDir(string $subdir = "") : string;
  public function saveJson(string $file, array &$array);
  public function showFilename(string $file);
}