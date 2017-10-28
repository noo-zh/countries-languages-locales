<?php

namespace CLL\Core;

use CLL\Core\Constants;

abstract class ExporterCommon extends Common implements Constants
{
  protected const SOURCES = [];
  
  /**
   * @var string
   */
  protected $module;
  
  /**
   * @var array
   */
  protected $params;
  
  protected abstract function loadSources();
  protected abstract function saveDataset();
  
  /**
   * @param string $module
   */
  public function __construct(string $module)
  {
    $this->module = $module;
  }

  /**
   * @param array $params
   */
  public function execute(array $params)
  {
    $this->params = $params;
    $this->basicCheckOfSources();
    $this->loadSources();
    $this->saveDataset();
  }
  
  /**
   * @throws \Exception
   */
  private function basicCheckOfSources()
  {
    if (is_array(static::SOURCES)) {
      foreach (static::SOURCES as $s) {
        $dir = $this->getSourceDir($s);
        
        if (!is_dir($dir)) {
          throw new \Exception("Dataset {$s} was not found");
        }
      }
    }
  }
  
  /**
   * @param string $param
   * @return bool
   */
  protected function isParam(string $param) : bool
  {
    return in_array($param, $this->params);
  }
  
  /**
   * @param string $subdir
   * @return string
   * @throws \Exception
   */
  public function createDistDir(string $subdir = "") : string
  {
    $subdir = ($subdir && substr($subdir, 0, 1) != "/") ? "/{$subdir}" : $subdir;
    $src = $this->module . implode("", $this->params);
    $dir = ROOT_DIR . self::DIR_DIST . "/{$src}" . $subdir;
    $parent = dirname($dir);
    
    if (is_writable($parent)) {
      if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
      }
    } else {
      throw new \Exception("Directory {$parent} is not writable");
    }
    
    return $dir;
  }
  
  /**
   * @param string $file
   * @param array $array
   * @throws \Exception
   */
  public function saveJson(string $file, array &$array)
  {
    if (!file_put_contents($file, json_encode($array))) {
      throw new \Exception("Writing JSON dataset to the file {$file} failed");
    }
  }
  
  /**
   * @param string $file
   */
  public function showFilename(string $file)
  {
    echo " > {$file}\n";
  }
  
  /**
   * 
   */
  public static function ok()
  {
    echo "Dataset was generated\n";
  }
}