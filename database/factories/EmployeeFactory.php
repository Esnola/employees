<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    public function withAvatar(): Factory|UserFactory
    {
        return $this->afterCreating(function (Employee $employee) {
            $url = 'https://ui-avatars.com/api/?name='.$employee->first_name.'+'.$employee->last_name.'&background=random';
            $contents = Http::get($url)->body();
            $name = Str::random(10).'.png';
            Storage::disk('public')->put('avatars/'.$name, $contents);
            $employee->update(['photo' => 'avatars/'.$name]);
        }
        );
    }

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            // 'photo' => $this->faker->imageUrl(150, 150),
            'phone' => fake()->phoneNumber(),
            'department' => fake()->randomElement([
                'Engineering',
                'Marketing',
                'Sales',
                'HR',
                'Finance',
                'Operations',
            ]),
            'position' => fake()->randomElement([
                'Manager',
                'Senior Developer',
                'Developer',
                'Designer',
                'Analyst',
                'Coordinator',
            ]),
            'salary' => fake()->numberBetween(3000000, 15000000),
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'status' => fake()->randomElement(['active', 'inactive']),
            'notes' => fake()->paragraph(3),
        ];
    }
}
