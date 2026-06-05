<?php

namespace App\Models;

use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'photo',
        'phone',
        'department',
        'position',
        'salary',
        'hire_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
        'department' => DepartmentEnum::class,
        'position' => PositionEnum::class,
        'hire_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::deleted(function (Employee $employee): void {
            self::deletePhotoFileIfUnreferenced($employee->photo);
        });
    }

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo) {
            return Storage::disk('public')->url($this->photo);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->full_name).'&background=random';
    }

    public static function deletePhotoFileIfUnreferenced(?string $photo): void
    {
        if (! $photo) {
            return;
        }

        $isRegistered = self::query()
            ->where('photo', $photo)
            ->exists();

        if (! $isRegistered) {
            Storage::disk('public')->delete($photo);
        }
    }

    public static function deleteManyWithPhotos(iterable $employees): void
    {
        foreach ($employees as $employee) {
            $employee->delete();
        }
    }

    public function formatHireDate(): string
    {
        return $this->hire_date->format('M d, Y');
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('department', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%");
        });
    }

    public function formatSalary(): string
    {
        return number_format($this->salary / 100, 2, ',', '.').' €';
    }
}
