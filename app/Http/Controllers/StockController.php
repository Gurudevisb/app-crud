<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all(); // Retrieve all stocks

        // Calculate total portfolio value (sum of qty * price for all stocks)
        $totalValue = Stock::sum(DB::raw('qty * price'));

        // Calculate the top-performing stock (highest value based on qty * price)
        $topStock = $stocks->sortByDesc(function ($stock) {
            return $stock->qty * $stock->price; // Calculate the stock's value (qty * price)
        })->first(); // Get the top-performing stock

        // Calculate the distribution of each stock (percentage of total portfolio value)
        $stocksDistribution = $stocks->map(function ($stock) use ($totalValue) {
            $stockValue = $stock->qty * $stock->price;
            $distributionPercentage = ($totalValue > 0) ? ($stockValue / $totalValue) * 100 : 0; // Avoid division by zero
            $stock->distributionPercentage = $distributionPercentage;
            return $stock;
        });

        return view('stocks.index', [
            'stocks' => $stocksDistribution, // Pass stocks with distribution data
            'totalValue' => $totalValue, // Pass total portfolio value
            'topStock' => $topStock, // Pass top-performing stock
        ]);
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'ticker' => 'nullable',
        ]);

        Stock::create($data);

        return redirect(route('stocks.index'))->with('success', 'Stock Created Successfully');
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', ['stock' => $stock]);
    }

    public function update(Stock $stock, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'ticker' => 'nullable',
        ]);

        $stock->update($data);

        return redirect(route('stocks.index'))->with('success', 'Stock Updated Successfully');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        // Reset the auto-increment counter to the highest ID + 1
        DB::statement("ALTER TABLE stocks AUTO_INCREMENT = 1");

        return redirect(route('stocks.index'))->with('success', 'Stock Deleted Successfully');
    }
}
