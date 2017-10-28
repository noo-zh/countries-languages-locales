<?php

namespace CLL;

use CLL\Core\Exporter;

define("ROOT_DIR", realpath(__DIR__ . "/.."));
require_once ROOT_DIR . "/vendor/autoload.php";

/**
 * @param array $args
 * @return string
 */
function getModule(array &$args) : string
{
  $count = count($args);
  
  if ($count < 2) {
    die("Invalid command [1]");
  }
  
  $module = $args[1];
  unset($args[0], $args[1]);
  
  return $module;
}

/**
 * @param array $args
 * @return array
 */
function getParams(array $args) : array
{
  $params = [];
  $count = count($args);
  
  if ($count > 0) {
    $params = array_values($args);
  }
  
  return $params;
}

/**
 * @param string $module
 * @return Exporter|null
 */
function checkClass(string $module) : ?Exporter
{
  $class = "\\CLL\\Exporters\\{$module}";
  
  if (class_exists($class)) {
    $instance = new $class($module);
    
    if ($instance instanceof Exporter) {
      return $instance;
    }
  }
  
  return null;
}

/**
 * @param array $args
 */
function executeExporter(array $args)
{
  $module = getModule($args);
  $params = getParams($args);
  $instance = checkClass($module);
  
  try {
    if ($instance) {
      $instance->execute($params);
    } else {
      throw new \Exception("Invalid exporter");
    }
  } catch (\Exception $ex) {
    die($ex->getMessage());
  }
}

executeExporter($argv);