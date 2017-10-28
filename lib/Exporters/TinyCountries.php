<?php

namespace CLL\Exporters;

use CLL\Core\ExporterCommon;
use CLL\Core\Exporter;
use CLL\Parsers\CountryList;
use CLL\Parsers\CountryData;
use CLL\Exporters\Interfaces;

class TinyCountries extends ExporterCommon implements Exporter, Interfaces\TinyCountries
{
  protected const SOURCES = [
    CountryList::ID,
    CountryData::ID
  ];
  
  private const PARAM_MULTI_LOCALE_ALPHA2 = "--ds-multi-locale-alpha2";
  private const PARAM_MULTI_LOCALE_ALPHA3 = "--ds-multi-locale-alpha3";
  
  /**
   * @var array
   */
  private $sources;
  
  /**
   * 
   */
  protected function loadSources()
  {
    $this->loadSourceCountryList();
    
    if ($this->isParam(self::PARAM_MULTI_LOCALE_ALPHA3)) {
      $this->loadSourceCountryData();
    }
  }
  
  /**
   * 
   */
  protected function saveDataset()
  {
    if ($this->isParam(self::PARAM_MULTI_LOCALE_ALPHA2)) {
      $this->saveDatasetMultiLocaleAlpha2();
    } elseif ($this->isParam(self::PARAM_MULTI_LOCALE_ALPHA3)) {
      $this->saveDatasetMultiLocaleAlpha3();
    } else {
      die("No valid dataset output");
    }
    
    parent::ok();
  }
  
  /**
   * 
   */
  private function loadSourceCountryList()
  {
    $this->sources[CountryList::ID] = (new CountryList())->load();
  }
  
  /**
   * 
   */
  private function loadSourceCountryData()
  {
    $this->sources[CountryData::ID] = (new CountryData())->load();
  }
  
  /**
   * @return CountryList
   */
  public function getCountryListSource() : CountryList
  {
    return $this->sources[CountryList::ID];
  }
  
  /**
   * @return CountryData
   */
  public function getCountryDataSource() : CountryData
  {
    return $this->sources[CountryData::ID];
  }
  
  /**
   * 
   */
  private function saveDatasetMultiLocaleAlpha2()
  {
    $ds = new TinyCountries\MultiLocaleAlpha2($this);
    $ds->export();
  }
  
  /**
   * 
   */
  private function saveDatasetMultiLocaleAlpha3()
  {
    $ds = new TinyCountries\MultiLocaleAlpha3($this);
    $ds->export();
  }
}