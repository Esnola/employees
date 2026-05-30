<?php

namespace App\Enums;

enum DepartmentEnum : string
{
    case Engineering = 'Engineering';
    case Finance = 'Finance';
    case HR = 'HR';
    case Marketing = 'Marketing';
    case Operations = 'Operations';
    case Sales = 'Sales';
  
  
  public function classes(): string
  {
    return match ($this) {
      self::Engineering => 'bg-blue-100/30! text-blue-500! border border-blue-500!',
      self::Finance => 'bg-amber-100/30! text-amber-500! border border-amber-500!',
      self::HR => 'bg-yellow-100/30! text-yellow-500! border border-yellow-500!',
      self::Marketing => 'bg-purple-100/30! text-purple-500! border border-purple-500!',
      self::Operations => 'bg-gray-100/30! text-gray-500! border border-gray-500!',
      self::Sales => 'bg-red-100/30! text-red-500! border border-red-500!',
    };
  }
}
