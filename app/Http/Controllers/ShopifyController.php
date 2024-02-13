<?php

namespace App\Http\Controllers;

use App\Http\Requests\FulfillOrder;
use App\Jobs\Shopify\Sync\Customer;
use App\Jobs\Shopify\Sync\Locations;
use App\Jobs\Shopify\Sync\OneOrder;
use App\Jobs\Shopify\Sync\Order;
use App\Jobs\Shopify\Sync\OrderFulfillments;
use App\Jobs\Shopify\Sync\Product;
use App\Models\FilterSetting;
use App\Models\ImportFullfillOrder;
use App\Models\Order as ModelsOrder;
use App\Models\Product as ModelsProduct;
use App\Models\Store;
use App\Models\User;
use App\Traits\RequestTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\OrdersExport;
use App\Models\CourierSetting;
use App\Models\Currency;
use App\Models\Customer as ModelsCustomer;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ShopifyController extends Controller
{

    use RequestTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders(Request $request)
    {
        $products = ModelsProduct::all();
        $user = Auth::user();
        $filters = '';
        $stores = '';
        if ($user->hasRole('SubUser')) {
            $st_id = explode(',', $user->store_id);
            $stores = Store::whereIn('table_id', $st_id)->get();
            // dd($stores);
            // $filters = FilterSetting::where('user_id', $user->parent_id)->get();
        } else {
            $stores = Store::where('user_id', $user->id)->get();
            // $store = $user->getShopifyStore;
        }
        $selected_store = base64_decode(request()->cookie('selected_sto'));
        // $store_selected_id = Store::where('name', $selected_store)->pluck('table_id')->first();
        if ($selected_store == 'all') {
            $filters = FilterSetting::where('user_id', $user->id)->where('user_id', $user->id)->get();
            // dd($filters);
        } else {
            $filters = FilterSetting::where('user_id', $user->id)
                ->whereJsonContains('value', ['store_ids' => $selected_store])
                ->get();
            // dd($filters);
        }
        $store_id = '';
        $storesids = '';
        $total_amount = 0;
        $orders = [];
        if ($request->filter != null) {
            if ($user->hasRole('SubUser')) {
                $user_iid = User::find($user->parent_id);
                $find_Currency = Currency::where('id', $user_iid->currency_id)->first();
            } else {
                $find_Currency = Currency::where('id', $user->currency_id)->first();
            }
            $filtersetting = FilterSetting::find($request->filter);
            $value = json_decode($filtersetting->value);
            $orders = ModelsOrder::orderBy('table_id', 'desc');
            $ordersTotalPricePending = ModelsOrder::where('financial_status', 'pending');
            if ($value->store_ids != 'all') {
                $store_ids = explode(",", $value->store_ids);
                $store_ids1 = Store::whereIn('name', $store_ids)->pluck('table_id');
                $orders = $orders->whereIn('store_id', $store_ids1);
                $ordersTotalPricePending = $ordersTotalPricePending->whereIn('store_id', $store_ids1);
            }
            if ($value->date_range != 'all') {
                // dd($value->date_range);

                if ($value->date_range == 'week') {
                    // dd($value->date_range);
                    $startDate = Carbon::now()->subDays(7)->startOfDay();
                    $orders = $orders->whereBetween('created_at_date', [$startDate, now()]);
                    $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('created_at_date', [$startDate, now()]);
                }
                if ($value->date_range == 'nextweek') {
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $orders = $orders->whereBetween('created_at_date', [$startOfWeek, $endOfWeek]);
                    $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('created_at_date', [$startOfWeek, $endOfWeek]);
                }
                if ($value->date_range == '1month') {
                    $last6DaysStartDate = Carbon::now()->subMonth()->startOfDay();
                    $last6DaysEndDate = now();
                    $orders = $orders->whereBetween('created_at_date', [$last6DaysStartDate, $last6DaysEndDate]);
                    $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('created_at_date', [$last6DaysStartDate, $last6DaysEndDate]);
                }
                if ($value->date_range == '6month') {
                    $last6DaysStartDate = Carbon::now()->subMonths(6)->startOfDay();
                    $last6DaysEndDate = now();
                    $orders = $orders->whereBetween('created_at_date', [$last6DaysStartDate, $last6DaysEndDate]);
                    $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('created_at_date', [$last6DaysStartDate, $last6DaysEndDate]);
                }
                if ($value->date_range == '1year') {
                    $last1YearStartDate  = Carbon::now()->subYear()->startOfDay();
                    $last1YearEndDate = now();
                    $orders = $orders->whereBetween('created_at_date', [$last1YearStartDate, $last1YearEndDate]);
                    // dd($orders);
                    $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('created_at_date', [$last1YearStartDate, $last1YearEndDate]);
                }
            }
            if ($value->fullfillment != '') {
                // dd($value->fullfillment);
                if ($value->fullfillment == 'unfulfilled') {
                    $orders = $orders->where('fulfillment_status', '!=', 'fulfilled')->where('fulfillment_status', '!=', 'partial');
                    $ordersTotalPricePending = $ordersTotalPricePending->where('fulfillment_status', '!=', 'fulfilled')->where('fulfillment_status', '!=', 'partial');
                } else {
                    $orders = $orders->where('fulfillment_status', $value->fullfillment);
                    $ordersTotalPricePending = $ordersTotalPricePending->where('fulfillment_status', $value->fullfillment);
                }
            }
            // if ($value->min_amount != '' || $value->max_amount != '') {
            //     $orders = $orders->whereBetween('total_price', [$value->min_amount, $value->max_amount]);
            //     $ordersTotalPricePending = $ordersTotalPricePending->whereBetween('total_price', [$value->min_amount, $value->max_amount]);
            // }
            $orders = $orders->get();
            $ordersTotalPricePending = $ordersTotalPricePending->sum('total_price');
        } elseif ($selected_store != 'all') {
            if ($user->hasRole('SubUser')) {
                $user_iid = User::find($user->parent_id);
                $find_Currency = Currency::where('id', $user_iid->currency_id)->first();
            } else {
                $find_Currency = Currency::where('id', $user->currency_id)->first();
            }


            $storesids = Store::where('name', $selected_store)->pluck('table_id')->first();
            $orders = ModelsOrder::where('store_id', $storesids)->orderBy('table_id', 'desc')
                ->get();
            $ordersTotalPricePending = ModelsOrder::where('store_id', $storesids)->where('financial_status', 'pending')
                ->orderBy('table_id', 'desc')
                ->sum('total_price');
        } else {

            if ($user->hasRole('SubUser')) {
                $user_iid = User::find($user->parent_id);
                $find_Currency = Currency::where('id', $user_iid->currency_id)->first();
                $storesids = Store::where('user_id', $user->parent_id)->pluck('table_id');
            } else {
                $find_Currency = Currency::where('id', $user->currency_id)->first();
                $storesids = Store::where('user_id', $user->id)->pluck('table_id');
            }
            $orders = ModelsOrder::whereIn('store_id', $storesids)->orderBy('table_id', 'desc')
                ->get();

            // dd($find_Currency);

            $ordersTotalPricePending = ModelsOrder::whereIn('store_id', $storesids)->where('financial_status', 'pending')
                ->orderBy('table_id', 'desc')
                ->sum('total_price');
        }
        $total_amount = $orders->sum('total_price');
        $totalLineItems = 0;
        $totalOrders = $orders->count();
        foreach ($orders as $order) {
            $lineItems = $order->line_items;
            if (is_array($lineItems)) {
                $totalLineItems += count($lineItems);
            }
        }

        $averageLineItemsPerOrder = ($totalOrders > 0) ? ($totalLineItems / $totalOrders) : 0;
        return view('orders.index', [
            'products' => $products,
            'filters' => $filters,
            'find_Currency' => $find_Currency,
            'orders' => $orders, 'totalOrders' => $totalOrders, 'ordersTotalPricePending' => $ordersTotalPricePending, 'averageLineItemsPerOrder' => $averageLineItemsPerOrder,
            'total_amount' => $total_amount, 'totalLineItems' => $totalLineItems, 'stores' => $stores, 'store_id' => $store_id
        ]);
    }
    public function export(Request $request)
    {
        // dd($request->all());
        // return Excel::download(new OrdersExport($request), 'orders.xlsx');
        return Excel::download(new OrdersExport($request), 'orders.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
    }

    public function showOrder($id)
    {
        $user = Auth::user();

        // $store = $user->getShopifyStore;
        $order = ModelsOrder::where('table_id', $id)->first();
        $store = Store::find($order->store_id);
        // dd($store);
        // $order = $store->getOrders()->where('table_id', $id)->first();
        if ($order->getFulfillmentOrderDataInfo()->doesntExist())
            OrderFulfillments::dispatch($user, $store, $order);
        $product_images = $store->getProductImagesForOrder($order);
        return view('orders.show', [
            'order_currency' => getCurrencySymbol($order->currency),
            'product_images' => $product_images,
            'order' => $order
        ]);
    }
    public function newshowOrder($id)
    {
        $user = Auth::user();

        $selected_store = base64_decode(request()->cookie('selected_sto'));

        $store = Store::where('name', $selected_store)->first();
        // $store = $user->getShopifyStore;
        $order = ModelsOrder::where('table_id', $id)->first();
        // dd($order->getFulfillmentOrderDataInfo());
        if ($order->getFulfillmentOrderDataInfo()->doesntExist())
            OrderFulfillments::dispatch($user, $store, $order);
        $product_images = $store->getProductImagesForOrder($order);
        return $order;
    }

    private function getFulfillmentLineItem($request, $order)
    {
        try {
            $search = (int) $request['lineItemId'];
            $fulfillment_orders = $order->getFulfillmentOrderDataInfo;
            // dd($fulfillment_orders);
            foreach ($fulfillment_orders as $fulfillment_order) {
                $line_items = $fulfillment_order->line_items;
                foreach ($line_items as $item) {
                    if ($item['line_item_id'] === $search) // Found it!
                        return $fulfillment_order;
                }
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    private function getPayloadForFulfillment($line_items, $request)
    {
        return [
            'fulfillment' => [
                'message' => $request['message'],
                'notify_customer' => $request['notify_customer'] === 'on',
                'tracking_info' => [
                    'number' => $request['number'],
                    'url' => $request['tracking_url'],
                    'company' => $request['shipping_company']
                ],
                'line_items_by_fulfillment_order' => $this->getFulfillmentOrderArray($line_items, $request)
            ]
        ];
    }

    private function getFulfillmentOrderArray($line_items, $request)
    {
        $temp_payload = [];
        $search = (int) $request['lineItemId'];
        foreach ($line_items as $line_item)
            if ($line_item['line_item_id'] === $search)
                $temp_payload[] = [
                    'fulfillment_order_id' => $line_item['fulfillment_order_id'],
                    'fulfillment_order_line_items' => [[
                        'id' => $line_item['id'],
                        'quantity' => (int) $request['no_of_packages']
                    ]]
                ];
        return $temp_payload;
    }

    private function checkIfCanBeFulfilledDirectly($fulfillment_order)
    {
        return in_array('request_fulfillment', $fulfillment_order->supported_actions);
    }

    private function getLineItemsByFulifllmentOrderPayload($line_items, $request)
    {
        $search = (int) $request['lineItemId'];
        foreach ($line_items as $line_item)
            if ($line_item['line_item_id'] === $search)
                return implode(',', [
                    'fulfillmentOrderId: "gid://shopify/FulfillmentOrder/' . $line_item['fulfillment_order_id'] . '"',
                    'fulfillmentOrderLineItems: { id: "gid://shopify/FulfillmentOrderLineItem/' . $line_item['id'] . '", quantity: ' . (int) $request['no_of_packages'] . ' }'
                ]);
    }

    private function getGraphQLPayloadForFulfillment($line_items, $request)
    {
        $temp = [];
        $temp[] = 'notifyCustomer: ' . ($request['notify_customer'] === 'on' ? 'true' : 'false');
        $temp[] = 'trackingInfo: { company: "' . $request['shipping_company'] . '", number: "' . $request['number'] . '", url: "' . $request['tracking_url'] . '"}';
        $temp[] = 'lineItemsByFulfillmentOrder: [{ ' . $this->getLineItemsByFulifllmentOrderPayload($line_items, $request) . ' }]';
        return implode(',', $temp);
    }

    private function getFulfillmentV2PayloadForFulfillment($line_items, $request)
    {
        $fulfillmentV2Mutation = 'fulfillmentCreateV2 (fulfillment: {' . $this->getGraphQLPayloadForFulfillment($line_items, $request) . '}) { 
            fulfillment { id }
            userErrors { field message }
        }';
        $mutation = 'mutation MarkAsFulfilledSubmit{ ' . $fulfillmentV2Mutation . ' }';
        return ['query' => $mutation];
    }

    public function fulfillOrderClear(Request $request)
    {
        foreach ($request['order_number'] as $Barcode) {
            $orderfullfill = ImportFullfillOrder::where('Barcode', $Barcode)->first();
            $orderfullfill->fullfill = 1;
            $orderfullfill->update();
            return response()->json('Full Fill Order Claer!', 200);
        }
    }
    public function fulfillOrder(Request $request)
    {

        // dd($request->all());
        // $user = Auth::user();
        // $store = $user->getShopifyStore;
        // $order = $store->getOrders()->where('table_id', (int) $request['order_id'])->first();
        // $fulfillment_order = $this->getFulfillmentLineItem($request, $order);

        try {
            $sendAndAcceptresponse = null;
            $request1 = $request->all();
            // dd($request1);
            $user = Auth::user();
            $selected_store = base64_decode(request()->cookie('selected_sto'));

            $store = Store::where('name', $selected_store)->first();
            // dd($store);
            // $store = $user->getShopifyStore;
            // dd($item);
            $count = 0;
            foreach ($request1['order_number'] as $Barcode) {
                // dd()
                $order = ModelsOrder::where('name', $Barcode)->first();
                // dd(count($order['line_items']));
                $full_fill_order_data = $this->newshowOrder($order->table_id);
                // dd($full_fill_order_data);
                $orderfullfill = ImportFullfillOrder::where('Barcode', $Barcode)->first();
                // dd($orderfullfill);
                $lineItemId = '';

                foreach ($order['line_items'] as $item) {
                    $count++;
                    // dd($item['id']);
                    $lineItemId = (string)$item['id'];
                    // dd($lineItemId);
                    $request = [
                        "lineItemId" => $lineItemId,
                        "number" => $orderfullfill->trackingid,
                        "shipping_company" => $request1['shipping_company'],
                        "no_of_packages" => "1",
                        "message" => 'Good',
                        "tracking_url" => $orderfullfill->tracking_url,
                        "notify_customer" => "off",
                        "order_id" => (string)$order->table_id
                    ];
                    $fulfillment_order = $this->getFulfillmentLineItem($request, $order);
                    // dd($fulfillment_order);
                    // dd($fulfillment_order);
                    if ($fulfillment_order !== null) {
                        $check = $this->checkIfCanBeFulfilledDirectly($fulfillment_order);
                        // dd($fulfillment_order);
                        if (!$check) {
                            $payload = $this->getFulfillmentV2PayloadForFulfillment($fulfillment_order->line_items, $request);
                            $api_endpoint = 'graphql.json';
                        } else {

                            if ($store->hasRegisteredForFulfillmentService())
                                $sendAndAcceptresponse = $this->sendAndAcceptFulfillmentRequests($store, $fulfillment_order);
                            $payload = $this->getPayloadForFulfillment($fulfillment_order->line_items, $request);
                            $api_endpoint = 'fulfillments.json';
                            // dd($payload);
                        }

                        $endpoint = getShopifyURLForStore($api_endpoint, $store);
                        $headers = getShopifyHeadersForStore($store);
                        $response = $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);
                        // dd($response);

                        if ($response['statusCode'] === 201 || $response['statusCode'] === 200)
                            OneOrder::dispatch($user, $store, $order->id);
                        Log::info('Response for fulfillment');
                        Log::info(json_encode($response));
                        // return response()->json(['response' => $response, 'sendAndAcceptresponse' => $sendAndAcceptresponse ?? null]);
                    } else {
                        return response()->json(['status' => false]);
                    }
                }
                $orderfullfill->fullfill = 1;
                $orderfullfill->update();
            }
            return redirect()->back();
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function singlefulfillOrder(FulfillOrder $request)
    {
        try {
            $sendAndAcceptresponse = null;
            $request = $request->all();
            // dd($request);
            $user = Auth::user();
            $order = ModelsOrder::where('table_id', (int) $request['order_id'])->first();
            $store = Store::where('table_id', $order->store_id)->first();
            $fulfillment_order = $this->getFulfillmentLineItem($request, $order);

            if ($fulfillment_order !== null) {
                $check = $this->checkIfCanBeFulfilledDirectly($fulfillment_order);
                if (!$check) {
                    // dd($request);
                    $payload = $this->getFulfillmentV2PayloadForFulfillment($fulfillment_order->line_items, $request);
                    $api_endpoint = 'graphql.json';
                    // dd($payload);
                } else {
                    // dd($store->hasRegisteredForFulfillmentService());
                    if ($store->hasRegisteredForFulfillmentService())
                        $sendAndAcceptresponse = $this->sendAndAcceptFulfillmentRequests($store, $fulfillment_order);
                    $payload = $this->getPayloadForFulfillment($fulfillment_order->line_items, $request);
                    $api_endpoint = 'fulfillments.json';
                }
                $endpoint = getShopifyURLForStore($api_endpoint, $store);
                $headers = getShopifyHeadersForStore($store);
                $response = $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);

                if ($response['statusCode'] === 201 || $response['statusCode'] === 200)
                    OneOrder::dispatch($user, $store, $order->id);

                Log::info('Response for fulfillment');
                Log::info(json_encode($response));
                return response()->json(['response' => $response, 'sendAndAcceptresponse' => $sendAndAcceptresponse ?? null]);
            }
            return response()->json(['status' => false]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    private function sendAndAcceptFulfillmentRequests($store, $fulfillment_order)
    {
        try {
            $responses = [];
            $responses[] = $this->callFulfillmentRequestEndpoint($store, $fulfillment_order);
            $responses[] = $this->callAcceptRequestEndpoint($store, $fulfillment_order);
            return ['status' => true, 'message' => 'Done', 'responses' => $responses];
        } catch (Exception $e) {
            return ['status' => false, 'error' => $e->getMessage() . ' ' . $e->getLine()];
        }
    }

    private function callFulfillmentRequestEndpoint($store, $fulfillment_order)
    {
        $endpoint = getShopifyURLForStore('fulfillment_orders/' . $fulfillment_order->id . '/fulfillment_request.json', $store);
        $headers = getShopifyHeadersForStore($store);
        $payload = [
            'fulfillment_request' => [
                'message' => 'Please fulfill ASAP'
            ]
        ];
        return $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);
    }

    private function callAcceptRequestEndpoint($store, $fulfillment_order)
    {
        $endpoint = getShopifyURLForStore('fulfillment_orders/' . $fulfillment_order->id . '/fulfillment_request/accept.json', $store);
        $headers = getShopifyHeadersForStore($store);
        $payload = [
            'fulfillment_request' => [
                'message' => 'Accepted the request on ' . date('F d, Y')
            ]
        ];
        return $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);
    }

    public function products()
    {
        $user = Auth::user();
        $store = $user->getShopifyStore;
        $products = $store->getProducts()
            ->select(['table_id', 'title', 'product_type', 'vendor', 'created_at', 'tags'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('products.index', ['products' => $products]);
    }

    public function syncProducts()
    {
        try {
            $user = Auth::user();
            $store = $user->getShopifyStore;
            Product::dispatch($user, $store);
            return back()->with('success', 'Product sync successful');
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error :' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function syncCustomers(Request $request)
    {
        try {
            $user = Auth::user();
            $store = '';
            // $store = $user->getShopifyStore;
            if ($user->hasRole('SubUser')) {
                if ($request->select_store != null) {
                    foreach ($request->select_store as $store_id) {
                        $store = Store::where('table_id', $request->select_store)->first();
                        Customer::dispatch($user, $store);
                    }
                } else {
                    $store = Store::where('user_id', $user->parent_id)->first();
                    Customer::dispatch($user, $store);
                }
            } else {
                if ($request->select_store != null) {
                    foreach ($request->select_store as $store_id) {
                        $store = Store::where('table_id', $store_id)->first();
                        // dd($store);
                        Customer::dispatch($user, $store);
                    }
                } else {
                    $store = Store::where('user_id', $user->id)->first();
                    Customer::dispatch($user, $store);
                }
            }
            return back()->with('success', 'Customer sync successful');
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error :' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    //Sync orders for Store using either GraphQL or REST API
    public function syncOrders(Request $request)
    {
        try {
            // $store = $user->getShopifyStore;
            $user = Auth::user();
            if ($request->sync_book_order == 'sync_order') {
                if ($request->select_store[0] == 'all') {
                    $stores = Store::where('user_id', $user->id)->get();
                    foreach ($stores as $store_id) {
                        $store = Store::where('table_id', $store_id->table_id)->first();
                        Order::dispatch($user, $store); //For using REST API
                    }
                } else {
                    foreach ($request->select_store as $store_id) {
                        $store = Store::where('table_id', $store_id)->first();
                        Order::dispatch($user, $store); //For using REST API
                    }
                }
            } else {
                $courierSetting = CourierSetting::where('user_id', auth()->user()->id)->first();
                // dd($courierSetting);
                $courierSettingValue = json_decode($courierSetting->value);
                // dd($courierSettingValue);
                foreach ($request->select_store as $store_id) {
                    $orders = ModelsOrder::where('store_id', $store_id)->pluck('tracking_id');
                }
                $username = $courierSettingValue->username;
                $password = $courierSettingValue->password;
                $encodedPassword = urlencode($password);

                foreach ($orders as $order) {
                    // dd($order);
                    if ($order != null) {
                        $consignment = $order;
                        $api_url = 'https://mnpcourier.com/mycodapi/api/Tracking/Consignment_Tracking' . "?username=$username&password=$encodedPassword&consignment=$consignment";
                        $ch = curl_init($api_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $responseData = json_decode($response);
                        $updateOrder = ModelsOrder::where('tracking_id', $order)->first();
                        $updateOrder->delivery_status = $responseData[0]->tracking_Details[0]->CNStatus;
                        $updateOrder->update();
                    }
                }
            }
            //Order::dispatch($user, $store, 'GraphQL'); //For using GraphQL API
            return back()->with('success', 'Order Sync');
        } catch (Exception $e) {
            toastr()->error('An error has occurred please try again later.');
            return response()->json(['status' => false, 'message' => 'Error :' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function syncOrdersOneStore($name)
    {
        try {
            $user = Auth::user();
            // $store = $user->getShopifyStore;
            $store = Store::where('name', $name)->first();
            // dd($store);
            Order::dispatch($user, $store); //For using REST API
            //Order::dispatch($user, $store, 'GraphQL'); //For using GraphQL API
            return back();
        } catch (Exception $e) {
            toastr()->error('An error has occurred please try again later.');
            return response()->json(['status' => false, 'message' => 'Error :' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function acceptCharge(Request $request)
    {
        try {
            $user = Auth::user();
            $store = $user->getShopifyStore;
            $charge_id = $request->charge_id;
            $user_id = $request->user_id;
            $endpoint = getShopifyURLForStore('application_charges/' . $charge_id . '.json', $store);
            $headers = getShopifyHeadersForStore($store);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            if ($response['statusCode'] === 200) {
                $body = $response['body']['application_charge'];
                if ($body['status'] === 'active') {
                    return redirect()->route('members.create')->with('success', 'Sub user created!');
                }
            }
            User::where('id', $user_id)->delete();
            return redirect()->route('members.create')->with('error', 'Some problem occurred while processing the transaction. Please try again.');
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error :' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function customers()
    {
        $user = Auth::user();
        $store_ids = explode(',', $user->store_id);
        $selected_store = base64_decode(request()->cookie('selected_sto'));
        $isSubUser = $user->hasRole('SubUser');
        $parent_id = $isSubUser ? $user->parent_id : $user->id;
        if ($selected_store != 'all') {
            // $store = Store::where('user_id', $parent_id)
            //     ->where('name', $selected_store)
            //     ->pluck('table_id');
            $stores = Store::select('table_id', 'name')->where('user_id', $parent_id)
                ->where('name', $selected_store)
                ->get();
            // dd($stores);
        } else {
            // $store = Store::whereIn('table_id', $store_ids)
            //     ->where('user_id', $parent_id)
            //     ->pluck('table_id');
            $stores = Store::select('table_id', 'name')->whereIn('table_id', $store_ids)
                ->where('user_id', $parent_id)
                ->get();
        }
        $final_stores = $stores->pluck('table_id')->toArray();
        $customers = ModelsCustomer::whereIn('store_id', $final_stores)->get();

        return view('customers.index', ['customers' => $customers, 'stores' => $stores]);
    }

    public function list(Request $request)
    {
        try {
            if ($request->ajax()) {
                $request = $request->all();
                $store = Auth::user()->getShopifyStore; //Take the auth user's shopify store
                $customers = $store->getCustomers(); //Load the relationship (Query builder)
                $customers = $customers->select(['first_name', 'last_name', 'email', 'phone', 'created_at']); //Select columns
                if (isset($request['search']) && isset($request['search']['value']))
                    $customers = $this->filterCustomers($customers, $request); //Filter customers based on the search term
                $count = $customers->count(); //Take the total count returned so far
                $limit = $request['length'];
                $offset = $request['start'];
                $customers = $customers->offset($offset)->limit($limit); //LIMIT and OFFSET logic for MySQL
                if (isset($request['order']) && isset($request['order'][0]))
                    $customers = $this->orderCustomers($customers, $request); //Order customers based on the column
                $data = [];
                $query = $customers->toSql(); //For debugging the SQL query generated so far
                $rows = $customers->get(); //Fetch from DB by using get() function
                if ($rows !== null)
                    foreach ($rows as $key => $item)
                        $data[] = array_merge(
                            ['#' => $key + 1], //To show the first column, NOTE: Do not show the table_id column to the viewer
                            $item->toArray()
                        );
                return response()->json([
                    "draw" => intval(request()->query('draw')),
                    "recordsTotal"    => intval($count),
                    "recordsFiltered" => intval($count),
                    "data" => $data,
                    "debug" => [
                        "request" => $request,
                        "sqlQuery" => $query
                    ]
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine()], 500);
        }
    }

    //Returns a Query builders after setting the logic for ordering customers by specified column
    public function orderCustomers($customers, $request)
    {
        $column = $request['order'][0]['column'];
        $dir = $request['order'][0]['dir'];
        $db_column = null;
        switch ($column) {
            case 0:
                $db_column = 'table_id';
                break;
            case 1:
                $db_column = 'first_name';
                break;
            case 2:
                $db_column = 'email';
                break;
            case 3:
                $db_column = 'phone';
                break;
            case 4:
                $db_column = 'created_at';
                break;
            default:
                $db_column = 'table_id';
        }
        return $customers->orderBy($db_column, $dir);
    }

    //Returns a Query builder after setting the logic for filtering customers by the search term
    public function filterCustomers($customers, $request)
    {
        $term = $request['search']['value'];
        return $customers->where(function ($query) use ($term) {
            $query->where(
                DB::raw("CONCAT(`first_name`, ' ', `last_name`)"),
                'LIKE',
                "%" . $term . "%"
            )
                ->orWhere('email', 'LIKE', '%' . $term . '%')
                ->orWhere('phone', 'LIKE', '%' . $term . '%');
        });
    }

    public function syncLocations()
    {
        try {
            $user = Auth::user();
            $store = $user->getShopifyStore;
            Locations::dispatch($user, $store);
            return back()->with('success', 'Locations synced successfully');
        } catch (Exception $e) {
            dd($e->getMessage() . ' ' . $e->getLine());
        }
    }

    public function syncOrder($id)
    {
        $user = Auth::user();
        $store = $user->getShopifyStore;
        $order = $store->getOrders()->where('table_id', $id)->select('id')->first();
        OneOrder::dispatchNow($user, $store, $order->id);
        return redirect()->route('shopify.order.show', $id)->with('success', 'Order synced!');
    }
    public function orderBulkPaymentPayment(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());
        $order_ids = explode(',', $request->captureIds);
        foreach ($order_ids as $order_id) {
            $order = ModelsOrder::where('table_id', $order_id)->first();
            $store = Store::where('table_id', $order['store_id'])->first();
            $headers = getShopifyHeadersForStore($store);
            $endpoint = getShopifyURLForStore('orders/' . $order->id . '/transactions.json', $store);
            $payload = [
                'transaction' => [
                    'amount' => $order->total_price_set['presentment_money']['amount'],
                    'kind' => 'capture',
                ]
            ];
            $response = $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);
            if (isset($response['statusCode']) || $response['statusCode'] === 200 || $response['statusCode'] === 201) {
                OneOrder::dispatchSync($user, $store, $order->id);
                return back()->with('success', 'Order Payment Status Updated!');
            } else {
                return back()->with('error', 'Order Payment Status Failed!');
            }
        }
    }
    public function orderPayment($order_id)
    {
        $user = Auth::user();
        $order = ModelsOrder::where('table_id', $order_id)->first();
        $store = Store::where('table_id', $order['store_id'])->first();
        // $api_endpoint =
        $endpoint = getShopifyURLForStore('orders/' . $order->id . '/transactions.json', $store);
        // dd($endpoint);

        $headers = getShopifyHeadersForStore($store);
        $payload = [
            'transaction' => [
                'amount' => $order->total_price_set['presentment_money']['amount'],
                'kind' => 'capture',
            ]
        ];

        $response = $this->makeAnAPICallToShopify('POST', $endpoint, null, $headers, $payload);
        // dd($response);
        if (isset($response['statusCode']) || $response['statusCode'] === 200 || $response['statusCode'] === 201) {
            OneOrder::dispatchSync($user, $store, $order->id);
            return back()->with('success', 'Order Payment Status Updated!');
        } else {
            return back()->with('error', 'Order Payment Status Failed!');
        }
    }
    public function fulfillOrderBook(Request $request)
    {
        $courierSetting = CourierSetting::where('user_id', auth()->user()->id)->first();
        $courierSettingValue = json_decode($courierSetting->value);
        $order_ids = explode(',', $request->bookIds);
        $datalist = [];
        foreach ($order_ids as $order_id) {
            $order = ModelsOrder::where('table_id', $order_id)->first();
            $newdata = [
                'consigneeName' => $order->shipping_address['first_name'] . '' . $order->shipping_address['last_name'],
                'consigneeAddress' => $order->shipping_address['address1'],
                'consigneeMobNo' => $order->phone,
                'consigneeEmail' => $order->email,
                'destinationCityName' => 'Lahore',
                'pieces' => count($order->line_items),
                'weight' => $order->grams == null ? 0.1 : $order->grams,
                'codAmount' => $order->total_price_set['presentment_money']['amount'],
                'custRefNo' => $order->id,
                'productDetails' => $order->line_items[0]['title'],
                'fragile' => $request->fragile,
                'Service' => $request->service,
                'Remarks' => $request->Remarks,
                'InsuranceValue' => 0,
                'locationID' => '18468'
            ];
            array_push($datalist, $newdata);
        }
        // dd($data);
        $data = [
            'username' => $courierSettingValue->username,
            'password' => $courierSettingValue->password,
            'AccountNo' => $courierSettingValue->accountNo,
            'BulkConsignmentList' => $datalist
        ];
        // dd($data);
        $api_url = 'https://mnpcourier.com/mycodapi/api/Booking/InsertBulkBookingData';
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response);
        $checkocunt = count($responseData);
        $count = 0;
        foreach ($responseData as $res) {
            foreach ($res->orderReferenceIdList as $orderRef) {
                if ($orderRef->success == true) {
                    $order = ModelsOrder::where('id', $orderRef->orderRefNum)->first();
                    $order->tracking_id = $orderRef->message;
                    $order->delivery_status = 'Booked';
                    $order->update();
                } else {
                    $count++;
                }
            }
        }
        if ($count != $checkocunt) {
            return back()->with('success', 'Order Booked!');
        } else {
            return back()->with('error', 'Already Booked!');
        }
    }
    public function changeRequestType(Request $request)
    {
        if ($request->changeRequestType == 'void_order') {
            $courierSetting = CourierSetting::where('user_id', auth()->user()->id)->first();
            $courierSettingValue = json_decode($courierSetting->value);
            $order_ids = explode(',', $request->orderids);
            $datalist = [];
            foreach ($order_ids as $order_id) {
                $order = ModelsOrder::where('table_id', $order_id)->first();
                array_push($datalist, $order->tracking_id);
            }
            $data = [
                'username' => $courierSettingValue->username,
                'password' => $courierSettingValue->password,
                'AccountNo' => $courierSettingValue->accountNo,
                'consignmentNumberList' => $datalist
            ];
            // dd($data);
            $api_url = 'http://mnpcourier.com/mycodapi/api/Booking/VoidConsignment';
            $ch = curl_init($api_url);
            // dd($data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded'
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $response = curl_exec($ch);
            curl_close($ch);
            $responseData = json_decode($response);
            $count = 0;
            foreach ($responseData as $res) {
                foreach ($res->orderReferenceIdList as $orderRef) {
                    if ($orderRef->success == true) {
                        $order = ModelsOrder::where('tracking_id', $orderRef->orderRefNum)->first();
                        $order->tracking_id = $orderRef->message;
                        $order->delivery_status = 'Voided';
                        $order->update();
                    } else {
                        $count++;
                    }
                }
            }
            return back()->with('success', 'Consignment Mark As Voided');
        } elseif ($request->changeRequestType == 'cancel_order') {
        }
    }
}
