<?php

namespace App\lib;

trait TraitInstantiable
{
  /**
   * Create a new instance of the class using late static binding.
   *
   * Supports constructor arguments.
   */
  public static function new(...$args): static
  {
    return new static(...$args);
  }
}
