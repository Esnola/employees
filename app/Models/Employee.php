<?php
  
  namespace App\Models;
  
  use App\Enums\DepartmentEnum;
  use App\Enums\PositionEnum;
  use App\Enums\StatusEnum;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\BelongsToMany;
  
  class Employee extends Model
  {
    use HasFactory;
    
    protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'phone',
      'department',
      'position',
      'salary',
      'hire_date',
      'status',
    ];
    
    protected $casts = [
      'status' => StatusEnum::class,
      'department' => DepartmentEnum::class,
      'position' => PositionEnum::class,
      'hire_date' => 'date'
    ];
    
    // Accessor for full name
    public function getFullNameAttribute(): string
    {
      return "{$this->first_name} {$this->last_name}";
    }
    
    public function formatHireDate(): string
    {
      return $this->hire_date->format('M d, Y');
    }
    
    
    // Scope for search
    public function scopeSearch($query, $search)
    {
      return $query->where(function($q) use ($search) {
        $q->where('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('department', 'like', "%{$search}%")
          ->orWhere('position', 'like', "%{$search}%");
      });
    }
    public function formatSalary(): string
    {
      return number_format($this->salary / 100 , 2, ',', '.') . ' €';
    }
  }
