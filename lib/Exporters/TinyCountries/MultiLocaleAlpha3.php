<?php

namespace CLL\Exporters\TinyCountries;

use CLL\Core\DatasetOutput;
use CLL\Exporters\Interfaces\TinyCountries;

class MultiLocaleAlpha3 implements DatasetOutput
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
    $alpha3Map = $this->exporter->getCountryDataSource();
    
    $locales = $source->getLocaleCodes();
    
    foreach ($locales as $locale) {
      $data = $source->getCountryData($locale);
      
      if ($data) {
        $newData = [];
        
        foreach ($data as $item) {
          $code = $alpha3Map->getAlpha3CountryCode($item["code"]);
          
          if ($code) {
            $item["code"] = $code;
            $newData[] = $item;
          }
        }
        
        $dir = $this->exporter->createDistDir();
        $json = $dir . sprintf(self::DIST_FILE, $locale);
        
        $this->exporter->saveJson($json, $newData);
        $this->exporter->showFilename($json);
      }
    }
  }
}