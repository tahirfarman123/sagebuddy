<?php

namespace App\Exports;

use App\Models\Order;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // dd($this->request->order_number);

        $orders = Order::whereIn('table_id', $this->request->order_number)->get();
        // dd($orders->line_items);
        // $dd = [];
        // foreach ($orders as $order) {
        //     foreach ($order->line_items as $line) {
        //         // dd($line['quantity']);
        //         array_push($dd, $line['quantity']);
        //     }
        // }

        // dd($orders[0]->line_items->quantity);
        return view('orders.export', [
            'orders' => $orders
        ]);
    }
}
