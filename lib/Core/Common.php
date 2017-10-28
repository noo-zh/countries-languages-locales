<?php

namespace CLL\Core;

use CLL\Core\Constants;

abstract class Common implements Constants
{
  /**
   * @param string $source
   * @return string
   */
  protected function getSourceDir(string $source) : string
  {
    return ROOT_DIR . self::DIR_SOURCES . "/{$source}";
  }
  
  /**
   * @param string $dir
   * @param string $file
   * @return string
   * @throws \Exception
   */
  protected function checkFile(string $dir, string $file) : string
  {
    $filepath = $dir . $file;
    
    if (!is_readable($filepath)) {
      throw new \Exception("Source file {$filepath} is not readable");
    }
    
    return $filepath;
  }
  
  /**
   * @param string $dir
   * @return string
   * @throws \Exception
   */
  protected function checkReadableDir(string $dir) : string
  {
    if (!is_readable($dir)) {
      throw new \Exception("Source directory {$dir} is not readable");
    }
    
    return $dir;
  }
  
  /**
   * @param string $file
   * @return array|null
   * @throws \Exception
   */
  protected function parseJson(string $file) : ?array
  {
    if (!is_readable($file)) {
      throw new \Exception("Source file {$file} is not readable");
    }
    
    $content = file_get_contents($file);
    
    if (!$content) {
      throw new \Exception("Reading of the file {$file} failed");
    }
    
    return json_decode($content, true);
  }
}