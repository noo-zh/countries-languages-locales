<?php

namespace CLL\Exporters\TinyLanguages;

use CLL\Core\DatasetOutput;
use CLL\Exporters\Interfaces\TinyLanguages;

class MultiLocaleLocale implements DatasetOutput
{ 
  private const DIST_FILE = "/%s-languages.json";
  
  /**
   * @var TinyLanguages 
   */
  private $exporter;
  
  /**
   * @param TinyLanguages $e
   */
  public function __construct(TinyLanguages $e)
  {
    $this->exporter = $e;
  }
  
  /**
   * 
   */
  public function export()
  {
    $source = $this->exporter->getLocaleListSource();
    $locales = $source->getLocaleCodes();
    
    foreach ($locales as $locale) {
      $data = $source->getLocaleData($locale);
      
      if ($data) {
        $dir = $this->exporter->createDistDir();
        $json = $dir . sprintf(self::DIST_FILE, $locale);
        
        $this->exporter->saveJson($json, $data);
        $this->exporter->showFilename($json);
      }
    }
  }
}