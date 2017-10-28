<?php

namespace CLL\Parsers;

use CLL\Core\Parser;
use CLL\Core\Common;

class LocaleList extends Common implements Parser
{
  public const ID = "locale-list";
  
  private const DATA_DIR = "/data";
  private const DATA_FILE = "/%s/locales.json";
  private const REGEX = "/^[a-z]{2}(_[A-Z]{2})?$/";
  
  /**
   * @var array
   */
  private $alpha2Codes;
  
  /**
   * @var array
   */
  private $alpha2Data;
  
  /**
   * @var array
   */
  private $localeCodes;
  
  /**
   * @var array
   */
  private $localeData;
  
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
        $m = [];
        
        if (preg_match(self::REGEX, $l, $m)) {
          if (empty($m[1])) {
            $this->alpha2Data[$locale][] = ["code" => $l, "name" => $name];
          } else {
            $this->localeData[$locale][] = ["code" => $l, "name" => $name];
          }
        }
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
  public function getAlpha2Data(string $locale) : array
  {
    return (isset($this->alpha2Data[$locale]) ? $this->alpha2Data[$locale] : []);
  }
  
  /**
   * @param string $locale
   * @return array
   */
  public function getLocaleData(string $locale) : array
  {
    return (isset($this->localeData[$locale]) ? $this->localeData[$locale] : []);
  }
}