<?php

namespace CLL\Exporters\TinyCountries;

use CLL\Core\DatasetOutput;
use CLL\Exporters\Interfaces\TinyCountries;

class MultiLocaleAlpha2 implements DatasetOutput
{ 
  private const DIST_FILE = "/%s-countries.json";
  
  /**
   * @var TinyCountries 
   */
  private $exporter;
  
  /**
   * @param TinyCountries $e
   */
  public function __construct(TinyCountries $e)
  {
    $this->exporter = $e;
  }
  
  /**
   * 
   */
  public function export()
  {
    $source = $this->exporter->getCountryListSource();
    $locales = $source->getLocaleCodes();
    
    foreach ($locales as $locale) {
      $data = $source->getCountryData($locale);
      
      if ($data) {
        $dir = $this->exporter->createDistDir();
        $json = $dir . sprintf(self::DIST_FILE, $locale);
        
        $this->exporter->saveJson($json, $data);
        $this->exporter->showFilename($json);
      }
    }
  }
}