<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TodosExport;

class ExportController extends Controller
{
    public function exportTodos()
    {
        $todos = Auth::user()->todos()->latest('id')->get();

        return Excel::download(new TodosExport($todos), 'todos.xlsx');
    }
}
