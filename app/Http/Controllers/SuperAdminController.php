<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallPrivateApp;
use App\Models\Currency;
use App\Models\Store;
use App\Models\User;
use App\Traits\RequestTrait;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Customer;
use App\Models\FulfillmentOrderData;
use App\Models\Order;

class SuperAdminController extends Controller
{
    use RequestTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'permission:all-access']);
    }

    public function index()
    {
        // $stores = User::with('stores')->get()
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::where('name', '!=', 'SuperAdmin')->get();
        $permissions = Permission::all()->pluck('name');
        $currencies = Currency::all();
        // $store = Store::with(['users.roles', 'users.permissions'])->get();

        $stores = Store::with(['users.roles', 'users.permissions'])->select(['id', 'currency_id', 'table_id', 'user_id', 'image', 'name', 'api_key', 'api_secret_key', 'access_token', 'myshopify_domain', 'created_at'])->get();
        // dd($stores);
        return view('superadmin.stores.index', ['stores' => $stores, 'currencies' => $currencies, 'users' => $users, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function create()
    {
        return view('superadmin.stores.create');
    }

    public function store(InstallPrivateApp $request)
    {
        try {
            $store_arr = [
                'api_key' => $request->api_key,
                'api_secret_key' => $request->api_secret_key,
                'myshopify_domain' => $request->myshopify_domain,
                'access_token' => $request->access_token
            ];
            $endpoint = getShopifyURLForStore('shop.json', $store_arr);
            $headers = getShopifyHeadersForStore($store_arr);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            if ($response['statusCode'] == 200) {
                $image = '';
                $shop_body = $response['body']['shop'];
                if (!empty(request()->file('image'))) {
                    $destinationPath = 'storage/images';
                    $extension = request()->file('image')->getClientOriginalExtension();
                    $fileName = 'storage/images/' . 'pi-' . time() . rand() . '.' . $extension;
                    request()->file('image')->move($destinationPath, $fileName);
                    $image = $fileName;
                }
                if ($request->select_user_type == 'existing') {
                    $user_id = $request->assign_to_user;
                    $newStore = Store::create(array_merge($store_arr, [
                        'id' => $shop_body['id'],
                        'email' => $shop_body['email'],
                        'user_id' => $user_id,
                        'name' => $shop_body['name'],
                        'phone' => $shop_body['phone'],
                        'address1' => $shop_body['address1'],
                        'address2' => $shop_body['address2'],
                        'image' => $image,
                        'zip' => $shop_body['zip'],
                        'currency_id' => $request->currency_id
                    ]));
                } else {

                    $user_payload = [
                        'name' => $request->name,
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'store_id' => '',
                        'currency_id' => $request->currency_id,
                        'name' => $shop_body['name']
                    ];
                    $user = User::create($user_payload);
                    $newStore = Store::create(array_merge($store_arr, [
                        'id' => $shop_body['id'],
                        'email' => $shop_body['email'],
                        'user_id' => $user->id,
                        'name' => $shop_body['name'],
                        'phone' => $shop_body['phone'],
                        'address1' => $shop_body['address1'],
                        'address2' => $shop_body['address2'],
                        'image' => $image,
                        'zip' => $shop_body['zip'],
                        'currency_id' => $request->currency_id
                    ]));
                    $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
                    if ($request->select_role == null) {
                        $user->assignRole('Admin');
                    } else {
                        foreach ($request->select_role as $role) {
                            $user->assignRole($role);
                        }
                    }
                    foreach ($request->select_permission as $permission) {
                        if ($permission !== 'all') {
                            $user->givePermissionTo($permission);
                        }
                    }
                }

                return back()->with('success', 'Installation Successful');
            }
            return back()->withInput()->with('error', 'Incorrect Credentials');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage() . ' ' . $e->getLine());
        }
    }
    public function update(Request $request, Store $store)
    {
        try {
            $image = '';
            if (!empty(request()->file('image'))) {
                $destinationPath = 'storage/images';
                $extension = request()->file('image')->getClientOriginalExtension();
                $fileName = 'storage/images/' . 'pi-' . time() . rand() . '.' . $extension;
                request()->file('image')->move($destinationPath, $fileName);
                $store->image = $fileName;
            }
            $store->access_token = $request->access_token;
            $store->api_key = $request->api_key;
            $store->api_secret_key = $request->api_secret_key;
            $store->currency_id = $request->currency_id;
            $store->myshopify_domain = $request->myshopify_domain;
            if ($request->select_user_type == 'existing') {
                $store->user_id = $request->assign_to_user;
            } else {
                $user_payload = [
                    'name' => $request->name,
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'currency_id' => $request->currency_id,
                    'store_id' => '',
                ];
                $user = User::Create($user_payload);
                $user->markEmailAsVerified();
                if ($request->select_role == null) {
                    $user->assignRole('Admin');
                } else {
                    foreach ($request->select_role as $role) {
                        $user->assignRole($role);
                    }
                }
                foreach ($request->select_permission as $permission) {
                    if ($permission !== 'all') {
                        $user->givePermissionTo($permission);
                    }
                }
            }
            $store->update();

            // $store_arr = [
            //     'api_key' => $request->api_key,
            //     'api_secret_key' => $request->api_secret_key,
            //     'myshopify_domain' => $request->myshopify_domain,
            //     'access_token' => $request->access_token
            // ];
            // $endpoint = getShopifyURLForStore('shop.json', $store_arr);
            // $headers = getShopifyHeadersForStore($store_arr);
            // $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            // if ($response['statusCode'] == 200) {

            // $shop_body = $response['body']['shop'];
            // $newStore = Store::create(array_merge($store_arr, [
            //     'id' => $shop_body['id'],
            //     'email' => $shop_body['email'],
            //     'user_id' => $user->id,
            //     'name' => $shop_body['name'],
            //     'phone' => $shop_body['phone'],
            //     'address1' => $shop_body['address1'],
            //     'address2' => $shop_body['address2'],
            //     'image' => $image,
            //     'zip' => $shop_body['zip'],
            //     'currency_id' => $request->currency_id
            // ]));
            // $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
            return back()->with('success', 'Installation Successful');
            // }
            // return back()->withInput()->with('error', 'Incorrect Credentials');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage() . ' ' . $e->getLine());
        }
    }

    public function sendIndex()
    {
        return view('superadmin.notifications.index', ['users' => User::where('id', '<>', Auth::user()->id)->select(['id', 'name',])->get()->toArray()]);
    }

    public function sendMessage(Request $request)
    {
        try {
            $user = User::where('id', (int) $request->user)->select(['id', 'name'])->first();
            $channel = $user->getChannelName('messages'); //Function in User.php Model
            $response = $this->sendSocketIONotification($channel, $request->message);
            return response()->json(['status' => true, 'message' => 'Sent message!', 'response' => $response]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function destroy(Store $store)
    {
        try {
            $fullfillment = FulfillmentOrderData::where('shop_id', $store->id)->delete();
            // dd($fullfillment);
            $customers = Customer::where('store_id', $store->table_id)->delete();
            $orders = Order::where('store_id', $store->table_id)->delete();
            $store->delete();
            return back()->with('Success', 'Store Deleted!');
        } catch (Exception $e) {
            return back()->with('error', 'Store Not Exist!');
        }
    }
}
