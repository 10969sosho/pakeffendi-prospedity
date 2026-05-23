<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::query()
            ->latest()
            ->paginate(25);

        return view('admin.sales-orders.index', compact('salesOrders'));
    }
}
