<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve all stocks
        $stocks = Stock::all();

        // Calculate total portfolio value
        $totalValue = $stocks->sum(function ($stock) {
            return $stock->qty * $stock->price;
        });

        // Find the top-performing stock
        $topStock = $stocks->sortByDesc(function ($stock) {
            return $stock->qty * $stock->price;
        })->first();

        // Pass variables to the Blade view
        return view('dashboard', [
            'totalValue' => $totalValue,
            'topStock' => $topStock,
        ]);
    }
}
