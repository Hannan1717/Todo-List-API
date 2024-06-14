<?php

namespace App\Http\Controllers;

use App\Imports\TodosImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importTodos(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        // Import data dari file Excel
        Excel::import(new TodosImport, $file);

        return response()->json(['message' => 'Import berhasil'], 200);
    }
}
