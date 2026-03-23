<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
        }

        return back()->withErrors(['email' => 'These credentials do not match our admin records.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalRevenue  = DB::table('orders')->sum('total') ?? 0;
        $totalOrders   = DB::table('orders')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('is_admin', false)->count();

        $recentOrders = DB::table('orders')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 30)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts',
            'totalCustomers', 'recentOrders', 'lowStockProducts'
        ));
    }

    public function products(Request $request)
    {
        $search     = $request->get('search', '');
        $products   = Product::with('category')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.products', compact('products', 'search', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_file'  => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            /** @var \CloudinaryLabs\CloudinaryLaravel\Model\CloudinaryUploadedFile $uploadedFile */
            $uploadedFile = Cloudinary::upload($request->file('image_file')->getRealPath(), ['folder' => 'products']);
            $imagePath = $uploadedFile->getSecurePath();
        }

        Product::create([
            'name'         => $request->name,
            'sku'          => $request->sku,
            'brand'        => $request->brand,
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'price'        => $request->price,
            'sale_price'   => $request->sale_price ?: null,
            'stock'        => $request->stock,
            'weight'       => $request->weight,
            'dimensions'   => $request->dimensions,
            'image'        => $imagePath,
            'tags'         => $request->tags,
            'is_featured'  => $request->boolean('is_featured'),
            'is_hot_offer' => $request->boolean('is_hot_offer'),
            'is_new_arrival' => $request->boolean('is_new_arrival'),
        ]);

        return back()->with('success', 'Product added successfully.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_file'  => 'nullable|image|max:10240',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            if ($imagePath && str_starts_with($imagePath, 'https://res.cloudinary.com')) {
                $publicId = pathinfo(parse_url($imagePath, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy('products/' . $publicId);
            }
            /** @var \CloudinaryLabs\CloudinaryLaravel\Model\CloudinaryUploadedFile $uploadedFile */
            $uploadedFile = Cloudinary::upload($request->file('image_file')->getRealPath(), ['folder' => 'products']);
            $imagePath = $uploadedFile->getSecurePath();
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $product->update([
            'name'           => $request->name,
            'sku'            => $request->sku,
            'brand'          => $request->brand,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'price'          => $request->price,
            'sale_price'     => $request->sale_price ?: null,
            'stock'          => $request->stock,
            'weight'         => $request->weight,
            'dimensions'     => $request->dimensions,
            'image'          => $imagePath,
            'tags'           => $request->tags,
            'is_featured'    => $request->boolean('is_featured'),
            'is_hot_offer'   => $request->boolean('is_hot_offer'),
            'is_new_arrival' => $request->boolean('is_new_arrival'),
        ]);

        return back()->with('success', 'Product updated successfully.');
    }

    public function orders(Request $request)
    {
        $search = $request->get('search', '');
        $orders = DB::table('orders')
            ->when($search, fn($q) => $q->where('id', 'like', "%{$search}%"))
            ->orderByDesc('created_at')
            ->get();

        return view('admin.orders', compact('orders', 'search'));
    }

    public function orderDetail($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return response()->json($order);
    }

    public function customers(Request $request)
    {
        $search    = $request->get('search', '');
        $customers = User::where('is_admin', false)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('id')
            ->get();

        $totalCustomers  = $customers->count();
        $totalRevenue    = 0;

        return view('admin.customers', compact('customers', 'search', 'totalCustomers', 'totalRevenue'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        return back()->with('success', 'Settings saved successfully.');
    }
}
