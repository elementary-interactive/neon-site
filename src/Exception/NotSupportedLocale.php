<?php
 
namespace Neon\Site\Exceptions;
 
use Exception;
 
class NotSupportedLocale extends Exception
{
  public function __construct($locale)
  {
    $this->message = "The given language ('{$locale}') is not available to set.";
  }
}