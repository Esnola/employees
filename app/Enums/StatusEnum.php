<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
  
  
  /**
   * @return string
   */
  public function classes(): string
  {
    return match ($this) {
      self::Active => 'bg-green-100/30! text-green-500! border border-green-500!',
      self::Inactive => 'bg-gray-100/30! text-gray-500! border border-gray-500!',
    };
  }
    
}
