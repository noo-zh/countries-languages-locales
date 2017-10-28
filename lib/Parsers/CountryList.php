<?php

namespace CLL\Parsers;

use CLL\Core\Parser;
use CLL\Core\Common;

class CountryList extends Common implements Parser
{
  public const ID = "country-list";
  
  private const DATA_DIR = "/data";
  private const DATA_FILE = "/%s/country.json";
  private const REGEX = "/^[a-z]{2}(_[A-Z]{2})?$/";
  
  /**
   * @var array
   */
  private $alpha2Codes;
  
  /**
   * @var array
   */
  private $localeCodes;
  
  /**
   * @var array
   */
  private $countryData;
  
  /**
   * @return Parser
   * @throws \Exception
   */
  public function load() : Parser
  {
    $dir = $this->checkReadableDir($this->getSourceDir(self::ID) . self::DATA_DIR);
    $od = opendir($dir);
      
    if (is_resource($od)) {
      $this->readDir($od);
      closedir($od);
    } else {
      throw new \Exception("Opening of the directory {$dir} failed");
    }
    
    return $this;
  }
  
  /**
   * @param resource $od
   * @throws \Exception
   */
  private function readDir($od)
  {
    foreach ($this->readDirEntry($od) as $locale) {
      $file = $this->checkFile($this->getSourceDir(self::ID) . self::DATA_DIR, sprintf(self::DATA_FILE, $locale));
      $parsedJson = $this->parseJson($file);
      
      if (!$parsedJson) {
        throw new \Exception("Parsing of the file {$file} failed");
      }
      
      $localeLength = strlen($locale);
      
      if ($localeLength == 2) {
        $this->alpha2Codes[] = $locale;
      } else {
        $this->localeCodes[] = $locale;
      }
      
      foreach ($parsedJson as $l => $name) {
        $this->countryData[$locale][] = ["code" => $l, "name" => $name];
      }
    }
  }
  
  /**
   * @param resource $od
   */
  private function readDirEntry($od)
  {
    while (($entry = readdir($od)) !== false) {
      if (is_string($entry) && substr($entry, 0, 1) != "." && preg_match(self::REGEX, $entry)) {
        yield $entry;
      }
    }
  }
  
  /**
   * @return array
   */
  public function getAlpha2Codes() : array
  {
    return $this->alpha2Codes;
  }
  
  /**
   * @return array
   */
  public function getLocaleCodes() : array
  {
    return $this->localeCodes;
  }
  
  /**
   * @param string $locale
   * @return array
   */
  public function getCountryData(string $locale) : array
  {
    return (isset($this->countryData[$locale]) ? $this->countryData[$locale] : []);
  }
}