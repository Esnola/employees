<?php
  
  namespace App\Imports;
  
  use App\Models\Employee;
  use Maatwebsite\Excel\Concerns\ToModel;
  use Maatwebsite\Excel\Concerns\WithHeadingRow;
  use Maatwebsite\Excel\Concerns\WithValidation;
  
  class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
  {
    public function model(array $row)
    {
      return new Employee([
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'email' => $row['email'],
        'phone' => $row['phone'] ?? null,
        'department' => $row['department'],
        'position' => $row['position'],
        'salary' => $row['salary'],
        'hire_date' => $row['hire_date'],
        'status' => $row['status'] ?? 'active',
      ]);
    }
    
    public function rules(): array
    {
      return [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:employees,email',
        'department' => 'required|string',
        'position' => 'required|string',
        'salary' => 'required|numeric',
        'hire_date' => 'required|date',
        'status' => 'in:active,inactive',
      ];
    }
  }
