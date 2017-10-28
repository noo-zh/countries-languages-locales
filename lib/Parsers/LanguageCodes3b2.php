<?php

namespace CLL\Parsers;

use CLL\Core\Parser;
use CLL\Core\Common;

class LanguageCodes3b2 extends Common implements Parser
{
  public const ID = "language-codes-3b2";
  private const FILENAME = "/language-codes-3b2_csv.csv";
  
  /**
   * @var array
   */
  private $mapAlpha2;
  
  /**
   * @var array
   */
  private $mapAlpha3;
  
  /**
   * @return Parser
   * @throws \Exception
   */
  public function load() : Parser
  {
    $file = $this->checkFile($this->getSourceDir(self::ID), self::FILENAME);
    $fp = fopen($file, "r");
      
    if (is_resource($fp)) {
      $this->parseCsv($fp);
      fclose($fp);
    } else {
      throw new \Exception("Opening of the file {$file} failed");
    }
    
    return $this;
  }
  
  /**
   * @param resource $fp
   */
  private function parseCsv($fp)
  {
    while (!feof($fp)) {
      $line = fgetcsv($fp, 160, ",");

      if (empty($line)) {
        break;
      }
      
      $alpha3 = (isset($line[0]) && is_string($line[0]) && strlen($line[0]) == 3) ? $line[0] : null;
      $alpha2 = (isset($line[1]) && is_string($line[1]) && strlen($line[1]) == 2) ? $line[1] : null;
      
      if ($alpha3 && $alpha2) {
        $this->mapAlpha2[$alpha2] = $alpha3;
        $this->mapAlpha3[$alpha3] = $alpha2;
      }
    }
  }
  
  /**
   * @param string $alpha3
   * @return string|null
   */
  public function getAlpha2(string $alpha3) : ?string
  {
    return (isset($this->mapAlpha3[$alpha3]) ? $this->mapAlpha3[$alpha3] : null);
  }
  
  /**
   * @param string $alpha2
   * @return string|null
   */
  public function getAlpha3(string $alpha2) : ?string
  {
    return (isset($this->mapAlpha2[$alpha2]) ? $this->mapAlpha2[$alpha2] : null);
  }
}