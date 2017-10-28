<?php

namespace CLL\Parsers;

use CLL\Core\Parser;
use CLL\Core\Common;

class CountryData extends Common implements Parser
{
  public const ID = "country-data";
  
  private const COUNTRIES_FILE = "/data/countries.json";
  
  /**
   * @var array
   */
  private $alpha3CountriesMap;
  
  /**
   * @return Parser
   * @throws \Exception
   */
  public function load() : Parser
  {
    $this->readCountriesMap();
    
    return $this;
  }
  
  /**
   * @throws \Exception
   */
  private function readCountriesMap()
  {
    $file = $this->checkFile($this->getSourceDir(self::ID), self::COUNTRIES_FILE);
    $parsedJson = $this->parseJson($file);
      
    if (!$parsedJson) {
      throw new \Exception("Parsing of the file {$file} failed");
    }
    
    foreach ($parsedJson as $country) {
      if ($country["alpha2"] && $country["alpha3"] && $country["status"] == "assigned") {
        $this->alpha3CountriesMap[$country["alpha2"]] = $country["alpha3"];
      }
    }
  }
  
  /**
   * @param string $alpha2
   * @return string|null
   */
  public function getAlpha3CountryCode(string $alpha2) : ?string
  {
    return (isset($this->alpha3CountriesMap[$alpha2]) ? $this->alpha3CountriesMap[$alpha2] : null);
  }
}