<?php

namespace CLL\Exporters\TinyLanguages;

use CLL\Core\DatasetOutput;
use CLL\Exporters\Interfaces\TinyLanguages;

class MultiLocaleMixed implements DatasetOutput
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
      $dataAlpha2 = $source->getAlpha2Data($locale);
      $dataLocale = $source->getLocaleData($locale);
      $data = [];
      
      if ($dataAlpha2) {
        $data += $dataAlpha2;
      }
      
      if ($dataLocale) {
        $data += $dataLocale;
      }
      
      if ($data) {
        $dir = $this->exporter->createDistDir();
        $json = $dir . sprintf(self::DIST_FILE, $locale);
        
        $this->exporter->saveJson($json, $data);
        $this->exporter->showFilename($json);
      }
    }
  }
}