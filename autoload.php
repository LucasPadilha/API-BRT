<?php


function __autoload($className) 
{
  $classPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace("\\", "/", $className) . '.php';

  if (file_exists($classPath)) {
    return require_once($classPath);
  }
  return null;
}