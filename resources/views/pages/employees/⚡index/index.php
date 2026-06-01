<?php
  
  use App\Enums\DepartmentEnum;
  use App\Enums\PositionEnum;
  use App\Enums\StatusEnum;
  use App\Exports\EmployeesExport;
  use App\Imports\EmployeesImport;
  use App\Models\Employee;
  use Barryvdh\DomPDF\Facade\Pdf;
  use Livewire\Attributes\Computed;
  use Livewire\Attributes\Title;
  use Livewire\Component;
  use Livewire\WithFileUploads;
  use Livewire\WithPagination;
  use Maatwebsite\Excel\Facades\Excel;
  
  new class extends Component {
    use WithPagination;
    use WithFileUploads;
    public string $title ='';
    
    // Add property for import
    public $importFile;
    
    // Filters
    public $search = '';
    public $department = '';
    public $position = '';
    public $status = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    
    // Pagination
    public $perPage = 10;
    
    // Selected employees for bulk actions
    public $selected = [];
    public $selectAll = false;
    
    // Modal state
    public $showDeleteModal = false;
    public $employeeToDelete = null;
    
    // Query string for URL persistence
    protected $queryString = [
      'search' => ['except' => ''],
      'department' => ['except' => ''],
      'position' => ['except' => ''],
      'status' => ['except' => ''],
      'sortField' => ['except' => 'first_name'],
      'sortDirection' => ['except' => 'asc'],
    ];
    
    
    public function mount()
    {
      $this->title = __('Employees List');
    }
    public function render()
    {
      return view('pages.employees.⚡index.index')
        ->title($this->title);
    }
/*    #[Computed]
    public function employees()
    {
      return Employee::query()
        ->when($this->search, fn($q) => $q->search($this->search))
        ->when($this->department, fn($q) => $q->where('department', $this->department))
        ->when($this->position, fn($q) => $q->where('position', $this->position))
        ->when($this->status, fn($q) => $q->where('status', $this->status))
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    }
    */
    #[Computed]
    public function departments()
    {
      return DepartmentEnum::cases();
    }
    
    #[Computed]
    public function statuses()
    {
      return StatusEnum::cases();
    }
    
    #[Computed]
    public function positions()
    {
      return PositionEnum::cases();
    }
    
    
    public function closeDeleteModal()
    {
      $this->showDeleteModal = false;
      // $this->reset(['employeeToDeleteId', 'employeeToDeleteName']);
    }
    
    public function sortBy(string $field): void
    {
      if ($this->sortField === $field) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        $this->sortField = $field;
        $this->sortDirection = 'asc';
      }
      
      $this->resetPage();
    }
    
    #[Computed]
    public function employees()
    {
      $enumFields = ['position', 'status', 'department'];
      
      $query = Employee::query()
        ->when($this->search, fn($q) => $q->search($this->search))
        ->when($this->department, fn($q) => $q->where('department', $this->department))
        ->when($this->position, fn($q) => $q->where('position', $this->position))
        ->when($this->status, fn($q) => $q->where('status', $this->status));
      
      if (!in_array($this->sortField, $enumFields)) {
        return $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);
      }
      
      $sorted = $query->get()->sortBy(
        fn($model) => $model->{$this->sortField}->label(),
        descending: $this->sortDirection === 'desc'
      )->values();
      
      $page = $this->getPage(); // <-- aquí
      
      return new \Illuminate\Pagination\LengthAwarePaginator(
        $sorted->forPage($page, $this->perPage),
        $sorted->count(),
        $this->perPage,
        $page,
        ['path' => request()->url()]
      );
    }
  /*  public function sortBy($field)
    {
      if ($this->sortField === $field) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        $this->sortField = $field;
        $this->sortDirection = 'asc';
      }
      
      $this->resetPage();
    }*/
    
    public function updatedSearch()
    {
      $this->resetPage();
    }
    
    public function updatedDepartment()
    {
      $this->resetPage();
    }
    
    public function updatedPosition()
    {
      $this->resetPage();
    }
    
    public function updatedStatus()
    {
      $this->resetPage();
    }
    
    public function resetFilters()
    {
      $this->reset(['search', 'department', 'position', 'status']);
      $this->resetPage();
    }
    
    public function confirmDelete($employeeId)
    {
      $this->employeeToDelete = $employeeId;
      $this->showDeleteModal = true;
    }
    
    
    public function deleteEmployee()
    {
      if ($this->employeeToDelete) {
        Employee::find($this->employeeToDelete)->delete();
        $this->showDeleteModal = false;
        $this->employeeToDelete = null;
        
        session()->flash('message', 'Employee deleted successfully.');
      }
    }
    
    public function updatedSelectAll($value)
    {
      if ($value) {
        $this->selected = $this->employees->pluck('id')->map(fn($id) => (string)$id)->toArray();
      } else {
        $this->selected = [];
      }
    }
    
    public function bulkDelete()
    {
      Employee::whereIn('id', $this->selected)->delete();
      $this->selected = [];
      $this->selectAll = false;
      
      session()->flash('message', __('Selected employees deleted successfully.'));
    }
    
    public function gotoButton($route)
    {
      return redirect()->route($route);
     }
      
      
      public function exportPdf()
    {
      $employees = Employee::query()
        ->when($this->search, fn($q) => $q->search($this->search))
        ->when($this->position, fn($q) => $q->where('position', $this->position))
        ->when($this->department, fn($q) => $q->where('department', $this->department))
        ->when($this->status, fn($q) => $q->where('status', $this->status))
        ->orderBy($this->sortField, $this->sortDirection)
        ->get();
      
      $pdf = Pdf::loadView('employees.pdf', [
        'employees' => $employees
      ]);
      
      return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
      }, 'employees-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function exportSelected()
    {
      $employees = Employee::whereIn('id', $this->selected)->get();
      
      $pdf = Pdf::loadView('employees.pdf', [
        'employees' => $employees
      ]);
      
      return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
      }, 'employees-selected-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function exportExcel()
    {
      return Excel::download(
        new EmployeesExport($this->getFilteredEmployees()),
        'employees-' . now()->format('Y-m-d') . '.xlsx'
      );
    }
    
    public function exportSelectedExcel()
    {
      $employees = Employee::whereIn('id', $this->selected)->get();
      
      return Excel::download(
        new EmployeesExport($employees),
        'employees-selected-' . now()->format('Y-m-d') . '.xlsx'
      );
    }
    
    public function import()
    {
      $this->validate([
        'importFile' => 'required|mimes:xlsx,xls,csv|max:2048',
      ]);
      
      try {
        Excel::import(new EmployeesImport, $this->importFile->path());
        
        session()->flash('message', 'Employees imported successfully.');
        
        $this->importFile = null;
      } catch (Exception $e) {
        session()->flash('error', 'Import failed: ' . $e->getMessage());
      }
    }
    
    private function getFilteredEmployees()
    {
      return Employee::query()
        ->when($this->search, fn($q) => $q->search($this->search))
        ->when($this->position, fn($q) => $q->where('position', $this->position))
        ->when($this->department, fn($q) => $q->where('department', $this->department))
        ->when($this->status, fn($q) => $q->where('status', $this->status))
        ->orderBy($this->sortField, $this->sortDirection)
        ->get();
    }
  };
