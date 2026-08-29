<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    public function index()
    {
        return response()->json(Table::orderBy('table_number', 'asc')->get());
    }
}
