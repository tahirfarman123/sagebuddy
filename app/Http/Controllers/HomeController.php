<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Traits\RequestTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    use RequestTrait;
    /**
     * Create a new controller instance.ckingU
     *
     * @return void
     */
    public function __construct()
    {
        //Test commit
    }

    public function testFull()
    {
        $orderNumber = '1004';
        $trackingId = '12456789';
        $trackingURL = "http://cameldelivery.ae/home/tracking?trackingid=$trackingId";



        $sendAndAcceptresponse = null;
        // $request = $request->all();
        $user = Auth::user();
        $store = $user->getShopifyStore;
        $order = $store->getOrders()->where('order_number', (int) $orderNumber)->first();

        return $order;
        // $fulfillment_order = $this->getFulfillmentLineItem($request, $order);
    }

    public function listUsers()
    {
        $data = User::where('email', '<>', 'superadmin@shopify.com')->get();
        return view('list_users', ['users' => $data]);
    }

    public function base(Request $request)
    {
        return redirect()->route('login');
    }

    public function checkPincodeAvailability(Request $request)
    {
        Log::info('Request received for product pincode check');
        Log::info($request->all());

        //Put the validation logic here
        $returnResp = ['status' => true, 'message' => 'Available'];

        return response()->json($returnResp, 200);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $store = '';
        $selected_store = base64_decode(request()->cookie('selected_sto'));
        if ($selected_store == "") {
            $value = base64_encode('all');
            cookie('selected_sto', $value, 3600);
        }
        if ($user->hasRole('SuperAdmin')) {
            $payload = $this->getSuperAdminDashboardPayload($user);
            return view('superadmin.home', $payload);
        } elseif ($user->hasRole('SubUser')) {
            // dd($user->parent_id);
            if (request()->hasCookie('selected_sto')) {
                $store = Store::where('name', base64_decode(request()->cookie('selected_sto')))->where('user_id', $user->parent_id)->get();
            } else {
                $store = Store::where('user_id', $user->parent_id)->get();
            }
            $payload = $this->getDashboardPayload($user, $store);
            return view('home', $payload);
        } else {
            if ($selected_store != 'all') {
                $store = Store::with('getOrders', 'getCustomers')->where('name', $selected_store)->where('user_id', $user->id)->get();
            } else {
                $store = Store::with('getOrders', 'getCustomers')->where('user_id', $user->id)->get();
            }
            $payload = $this->getDashboardPayload($user, $store);
            return view('home', $payload);
        }
    }
    public function selectStore($name)
    {
        if ($name == 'all') {
            $value = base64_encode($name);
            $cookie = cookie('selected_sto', $value, 3600);
            return response('Update Store', 200)->cookie($cookie);
        } else {
            $value = base64_encode($name);
            $cookie = cookie('selected_sto', $value, 3600);
            return response('Update Store', 200)->cookie($cookie);
        }
    }

    public function getSuperAdminDashboardPayload($user)
    {
        try {
            $stores_count = Store::count();
            $private_stores = Store::where('api_key', '<>', null)->where('api_secret_key', '<>', null)->count();
            $public_stores = Store::where('api_key', null)->where('api_secret_key', null)->count();
            return [
                'stores_count' => $stores_count,
                'private_stores' => $private_stores,
                'public_stores' => $public_stores
            ];
        } catch (Exception $e) {
            return [
                'stores_count' => 0,
                'private_stores' => 0,
                'public_stores' => 0
            ];
        }
    }

    private function getDashboardPayload($user, $stores)
    {
        try {
            // $orders = $stores->getOrders;
            $orders = 0;
            $sum = 0;
            $customers_count = 0;
            foreach ($stores as $store) {
                // dd($store->getCustomers);
                $orders += $store->getOrders->count();
                $sum += $store->getOrders->sum('total_price');
                $customers_count += $store->getCustomers->count();
            }
            // dd();
            return [
                'orders_count' => $orders ?? 0,
                'orders_revenue' => $sum ?? 0,
                'customers_count' => $customers_count ?? 0
            ];
        } catch (Exception $e) {
            return [
                'orders_count' => 0,
                'orders_revenue' => 0,
                'customers_count' => 0
            ];
        }
    }

    public function testDocker()
    {
        $endpoint = getDockerURL('ping/processor', 8010);
        $headers = getDockerHeaders();
        $response = $this->makeADockerAPICall($endpoint, $headers);
        return response()->json($response);
    }

    public function indexElasticSearch()
    {
        $endpoint = getDockerURL('index/elasticsearch', 8010);
        $headers = getDockerHeaders();
        $response = $this->makeADockerAPICall($endpoint, $headers);
        return back()->with('success', 'Indexing Complete. Response ' . json_encode($response));
    }

    public function searchStore(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('searchTerm')) {
                $searchTerm = $request->searchTerm;
                $endpoint = getDockerURL('search/store?search=' . $searchTerm, 8010);
                $headers = getDockerHeaders();
                $response = $this->makeADockerAPICall($endpoint, $headers);
                return response()->json($response);
            }
        }
        return response()->json(['status' => false, 'message' => 'Invalid Request']);
    }
}
