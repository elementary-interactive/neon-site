<?php
 
namespace Neon\Site\Exceptions;
 
use Exception;
 
class DomainNotSetProperlyException extends Exception
{
  public function __construct($domain)
  {
    $this->message = "Current {$domain} is not set, please ask the engineer!";
  }
}