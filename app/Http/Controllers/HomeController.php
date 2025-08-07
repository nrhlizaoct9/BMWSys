<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // $transactionsToday = Transaction::whereDate('created_at', today())->count();
        // $productCount = Product::count();
        $serviceCount = Service::count();

        return view('dashboard', [
            // 'transactionsToday' => $transactionsToday,
            // 'productCount' => $productCount,
            'serviceCount' => $serviceCount,
        ]);
    }
}
