<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataTableService;

class DataTableController extends Controller
{
    public function index(Request $request, string $table)
    {
        return app(DataTableService::class)
            ->make($table, $request);
    }
}
