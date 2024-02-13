<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallPrivateApp;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\FulfillmentOrderData;
use App\Models\Order;
use App\Models\OrderFulfillment;
use App\Models\Store;
use App\Models\User;
use App\Traits\RequestTrait;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PDO;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    use RequestTrait;
    public function index()
    {
        // dd('dd');
        $user = Auth::user()->id;
        $stores = Store::where('user_id', $user)->select(['id', 'table_id', 'name', 'image', 'api_key', 'api_secret_key', 'access_token', 'myshopify_domain', 'created_at'])->get();
        $currencies = Currency::all();
        return view('admin.stores.index', ['stores' => $stores, 'currencies' => $currencies]);
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(InstallPrivateApp $request)
    {
        try {
            // dd($request->all());

            $store_arr = [
                'api_key' =>  $request->api_key,
                'api_secret_key' => $request->api_secret_key,
                'myshopify_domain' => $request->myshopify_domain,
                'access_token' =>  $request->access_token
            ];
            $endpoint = getShopifyURLForStore('shop.json', $store_arr);
            $headers = getShopifyHeadersForStore($store_arr);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            // dd($response);
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
                $newStore = Store::create(array_merge($store_arr, [
                    'id' => $shop_body['id'],
                    'email' => $shop_body['email'],
                    'name' => $shop_body['name'],
                    'phone' => $shop_body['phone'],
                    'user_id' => Auth()->user()->id,
                    'address1' => $shop_body['address1'],
                    'address2' => $shop_body['address2'],
                    'zip' => $shop_body['zip'],
                    'currency_id' => $request->currency_id,
                    'image' => $image
                ]));
                $user = User::where('email', $shop_body['email'])->first();
                if ($user === null && Auth::user()->hasPermissionTo('all-access')) {
                    $user_payload = [
                        'email' => $request['email'],
                        // 'password' => Hash::make('password'),
                        'password' => Hash::make($request['password']),
                        'store_id' => $newStore->table_id,
                        'name' => $shop_body['name']
                    ];
                    $user = User::updateOrCreate(['email' => $shop_body['email']], $user_payload);
                    $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
                    $user->assignRole('admin');
                    $default_permissions = Permission::all();
                    foreach ($default_permissions as $permission)
                        $user->givePermissionTo($permission->name);
                }
                return back()->with('success', 'Installation Successful');
            }
            return back()->withInput()->with('error', 'Incorrect Credentials');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage() . ' ' . $e->getLine());
        }
    }
    public function update(Request $request)
    {
        try {
            // dd($request->all());

            $store_arr = [
                'api_key' =>  $request->api_key,
                'api_secret_key' => $request->api_secret_key,
                'myshopify_domain' => $request->myshopify_domain,
                'access_token' =>  $request->access_token
            ];
            $endpoint = getShopifyURLForStore('shop.json', $store_arr);
            $headers = getShopifyHeadersForStore($store_arr);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            // dd($response);
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
                // dd($shop_body['id']);
                $store = Store::where('id', $shop_body['id'])->first();
                if ($store != null) {
                    $store->id = $shop_body['id'];
                    $store->email = $shop_body['email'];
                    $store->name = $shop_body['name'];
                    $store->phone = $shop_body['phone'];
                    $store->user_id = Auth()->user()->id;
                    $store->address1 = $shop_body['address1'];
                    $store->address2 = $shop_body['address2'];
                    $store->zip = $shop_body['zip'];
                    $store->currency_id = $request->currency_id;
                    if (!empty(request()->file('image'))) {
                        $store->image = $image;
                    }
                    $store->update();
                    $user = User::where('email', $shop_body['email'])->first();
                    if ($user === null && Auth::user()->hasPermissionTo('all-access')) {
                        $user_payload = [
                            'email' => $request['email'],
                            // 'password' => Hash::make('password'),
                            'password' => Hash::make($request['password']),
                            'store_id' => $store->table_id,
                            'currency_id' => $request->currency_id,
                            'name' => $shop_body['name']
                        ];
                        $user = User::where('email', $shop_body['email'])->first();
                        $user->email = $request['email'];
                        // $user->password = ;
                        $user->store_id = $store->table_id;
                        $user->name = $shop_body['name'];
                        $store->currency_id = $request->currency_id;
                        $user->update();
                        $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
                        $user->assignRole('admin');
                        foreach (config('custom.default_permissions') as $permission)
                            $user->givePermissionTo($permission);
                    }
                    return back()->with('success', 'Update Successful');
                } else {
                    return back()->with('error', 'No Store Exist');
                }
            }
            return back()->withInput()->with('error', 'Incorrect Credentials');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage() . ' ' . $e->getLine());
        }
    }

    public function sendIndex()
    {
        return view('admin.notifications.index', ['users' => User::where('id', '<>', Auth::user()->id)->select(['id', 'name',])->get()->toArray()]);
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
    public function subUser()
    {
        $user = Auth::user()->id;
        $stores = Store::where('user_id', $user)->get();
        $users = User::with('roles', 'permissions')->where('parent_id', $user)->get();
        // dd($users);
        $roles = Role::where('name', '!=', 'SuperAdmin')->get();
        $permission = Permission::all()->pluck('name');
        // dd($permission);
        return view('admin.users.index', ['users' => $users, 'stores' => $stores, 'roles' => $roles, 'permission' => $permission]);
    }
    public function storeUser(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->Password);
            $user->store_id = implode(',', $request->select_store);
            $user->parent_id = Auth::user()->id;
            $user->save();
            $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
            foreach ($request->select_role as $role) {
                $user->assignRole($role);
            }
            foreach ($request->select_permission as $permission)
                $user->givePermissionTo($permission);
            return back()->with('Success', 'User Created!');
        } catch (Exception $e) {
            return back()->with('error', 'Unbale to Create user!');
        }
        // $request->validate([
        //     'email' => dup;
        // ]);
    }
    public function updateUser(Request $request)
    {
        try {
            // dd($request->all());
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->Password);
            $user->store_id = implode(',', $request->select_store);
            $user->parent_id = Auth::user()->id;
            // dd($user);
            $user->update();
            // dd($request->select_role);
            // foreach ($request->select_role as $role) {
            $user->syncRoles($request->select_role);
            $user->syncPermissions($request->select_permission);
            // }
            return back()->with('Success', 'User Updated!');
        } catch (Exception $e) {
            return back()->with('error', 'Unbale to Create user!');
        }
        // $request->validate([
        //     'email' => dup;
        // ]);
    }
    public function destroyUser($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return back()->with('Success', 'User Deleted!');
        } catch (Exception $e) {
            return back()->with('error', 'Something Went Wrong!');
        }
    }
    public function destroyStore($id)
    {
        try {
            $store = Store::find($id);
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
