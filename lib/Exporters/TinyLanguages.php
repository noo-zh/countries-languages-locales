<?php

namespace CLL\Exporters;

use CLL\Core\ExporterCommon;
use CLL\Core\Exporter;
use CLL\Parsers\LocaleList;
use CLL\Parsers\LanguageCodes3b2;
use CLL\Exporters\Interfaces;

class TinyLanguages extends ExporterCommon implements Exporter, Interfaces\TinyLanguages
{
  protected const SOURCES = [
    LocaleList::ID,
    LanguageCodes3b2::ID
  ];
  
  private const PARAM_MULTI_LOCALE_ALPHA2 = "--ds-multi-locale-alpha2";
  //private const PARAM_MULTI_LOCALE_ALPHA3 = "--ds-multi-locale-alpha3";
  private const PARAM_MULTI_LOCALE_LOCALE = "--ds-multi-locale-locale";
  private const PARAM_MULTI_LOCALE_MIXED = "--ds-multi-locale-mixed";
  
  /**
   * @var array
   */
  private $sources;
  
  /**
   * 
   */
  protected function loadSources()
  {
    $this->loadSourceLocaleList();
    
    /*if ($this->isParam(self::PARAM_MULTI_LOCALE_ALPHA3)) {
      $this->loadSourceLanguageCodes3b2();
    }*/
  }
  
  /**
   * 
   */
  protected function saveDataset()
  {
    if ($this->isParam(self::PARAM_MULTI_LOCALE_ALPHA2)) {
      $this->saveDatasetMultiLocaleAlpha2();
    } elseif ($this->isParam(self::PARAM_MULTI_LOCALE_LOCALE)) {
      $this->saveDatasetMultiLocaleLocale();
    } elseif ($this->isParam(self::PARAM_MULTI_LOCALE_MIXED)) {
      $this->saveDatasetMultiLocaleMixed();
    } else {
      die("No valid dataset output");
    }
    
    parent::ok();
  }
  
  /**
   * 
   */
  private function loadSourceLocaleList()
  {
    $this->sources[LocaleList::ID] = (new LocaleList())->load();
  }
  
  /**
   * 
   */
  private function loadSourceLanguageCodes3b2()
  {
    $this->sources[LanguageCodes3b2::ID] = (new LanguageCodes3b2())->load();
  }
  
  /**
   * @return LocaleList
   */
  public function getLocaleListSource() : LocaleList
  {
    return $this->sources[LocaleList::ID];
  }
  
  /**
   * @return LanguageCodes3b2
   */
  public function getLanguageCodes3b2Source() : LanguageCodes3b2
  {
    return $this->sources[LanguageCodes3b2::ID];
  }
  
  /**
   * 
   */
  private function saveDatasetMultiLocaleAlpha2()
  {
    $ds = new TinyLanguages\MultiLocaleAlpha2($this);
    $ds->export();
  }
  
  /**
   * 
   */
  private function saveDatasetMultiLocaleLocale()
  {
    $ds = new TinyLanguages\MultiLocaleLocale($this);
    $ds->export();
  }
  
  /**
   * 
   */
  private function saveDatasetMultiLocaleMixed()
  {
    $ds = new TinyLanguages\MultiLocaleMixed($this);
    $ds->export();
  }
}