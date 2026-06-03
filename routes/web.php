<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/employees');
Route::livewire('/employees', 'pages::employees.index')->name('employees.index');
Route::livewire('/employees/{employee}/show', 'pages::employees.show')->name('employees.show');
