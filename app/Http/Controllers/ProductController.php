<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\CartUpdated;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort_by == 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($request->sort_by == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort_by == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }

        $products = $query->get();
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $productIdsInCart = array_keys($cart);
        return view('products.index', compact('products','cartCount','productIdsInCart'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stitch' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('images/product/'), $name);
                $images[] = $name;
            }
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stitch' => $request->stitch,
            'description' => $request->description,
            'images' => json_encode($images),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stitch' => 'required',
            'description' => 'required',
            'images' => 'sometimes',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $existingImages = $request->input('existing_images', []);
        $deletedImages = json_decode($request->input('deleted_images', '[]'));

        // Remove deleted images from storage
        if (!empty($deletedImages)) {

            foreach ($deletedImages as $deletedImage) {
                if (($key = array_search($deletedImage, $existingImages)) !== false) {
                    unset($existingImages[$key]);
                    // Delete the image file from the storage
                    \File::delete(public_path('images/product/' . $deletedImage));
                }
            }
        }

        $images = $existingImages;

        // Handle new images upload
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('images/product/'), $name);
                $images[] = $name;
            }
        }

        $data['images'] = json_encode(array_values($images)); // Reindex the array

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function show(Product $product)
    {

        return view('products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    public function addToCart(Request $request,$id) 
    {
        $cart = session()->get('cart', []);
        $product = Product::find($id);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'images' => $product->images
            ];
        }

        session()->put('cart', $cart);
        // event(new CartUpdated(session()->get('cart', [])));
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    
}
