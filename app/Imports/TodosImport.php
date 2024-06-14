<?php

namespace App\Imports;


use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TodosImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Todo([
            'user_id' => Auth::id(), // Menggunakan user_id dari user yang sedang login
            'name' => $row['task'], // Mapping dari header 'name' di Excel ke kolom 'name' di tabel
            'status' => $row['status'], // Mapping dari header 'status' di Excel ke kolom 'status' di tabel
            'created_at' => Carbon::createFromFormat('d/m/Y', $row['assigned']), // Mengubah format tanggal
            'updated_at' => Carbon::createFromFormat('d/m/Y', $row['updated']), // Mengubah format tanggal
        ]);
    }
}
