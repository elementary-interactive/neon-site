<?php

namespace Neon\Site\Models\Interfaces;

interface Site
{
  public function getDomainPattern(): string;

  public function getPrefixPattern(): string;
}