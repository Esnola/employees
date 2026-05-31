<?php

namespace App\Enums;

enum PositionEnum:string
{
    case Analyst = 'Analyst';
    case Coordinator = 'Coordinator';
    case Designer = 'Designer';
    case Developer = 'Developer';
    case Manager = 'Manager';
    case SeniorDeveloper = 'Senior Developer';
  
  public function classes(): string
    {
      return match ($this) {
        self::Analyst => 'bg-blue-100/30! text-blue-500! border border-blue-500!',
        self::Coordinator => 'bg-amber-100/30! text-amber-500! border border-amber-500!',
        self::Designer => 'bg-yellow-100/30! text-yellow-500! border border-yellow-500!',
        self::Developer => 'bg-purple-100/30! text-purple-500! border border-purple-500!',
        self::Manager => 'bg-gray-100/30! text-gray-500! border border-gray-500!',
        self::SeniorDeveloper => 'bg-red-100/30! text-red-500! border border-red-500!',
      };
    }
}
