<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use App\Models\Ingredient;
use App\Models\InventoryLog;
use App\Models\MixedIngredient;

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'ingredientCount' => Ingredient::count(),
            'inventoryLogCount' => InventoryLog::count(),
            'cashflowCount' => Cashflow::count(),
            'mixedCount' => MixedIngredient::count(),
        ]);
    }
}
