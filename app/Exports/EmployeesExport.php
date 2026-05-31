<?php
  
  namespace App\Exports;
  
  use App\Models\Employee;
  use Maatwebsite\Excel\Concerns\FromCollection;
  use Maatwebsite\Excel\Concerns\WithHeadings;
  use Maatwebsite\Excel\Concerns\WithMapping;
  
  class EmployeesExport implements FromCollection, WithHeadings, WithMapping
  {
    protected $employees;
    
    public function __construct($employees = null)
    {
      $this->employees = $employees;
    }
    
    public function collection()
    {
      return $this->employees ?? Employee::all();
    }
    
    public function headings(): array
    {
      return [
        'ID',
        'First Name',
        'Last Name',
        'Email',
        'Phone',
        'Department',
        'Position',
        'Salary',
        'Hire Date',
        'Status',
      ];
    }
    
    public function map($employee): array
    {
      return [
        $employee->id,
        $employee->first_name,
        $employee->last_name,
        $employee->email,
        $employee->phone,
        $employee->department instanceof \BackedEnum ? $employee->department->value : $employee->department,
        $employee->position instanceof \BackedEnum ? $employee->position->value : $employee->position,
        $employee->salary,
        $employee->hire_date->format('Y-m-d'),
        $employee->status instanceof \BackedEnum ? $employee->status->value : $employee->status,
      ];
    }
  }
