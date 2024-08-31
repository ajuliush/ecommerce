<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->orderBy('id', 'DESC')->paginate(10);
        return view('backend.product.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('backend.product.create', compact('brands', 'categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedFileExtensions = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $g_check = in_array($extension, $allowedFileExtensions);
                if ($g_check) {
                    $g_fileName = $current_timestamp . $counter . "." . $extension;
                    $this->GenerateProductThumbnailImage($file, $g_fileName);
                    array_push($gallery_arr, $g_fileName);
                    $counter++;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }

        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('product.index')->with('status', 'Product added successfully.');
    }
    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());
        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('backend.product.edit', compact('product', 'brands', 'categories'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Handling the main product image
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
                File::delete(public_path('uploads/products') . '/' . $product->image);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handling gallery images
        $gallery_arr = [];
        $gallery_images = $product->images; // Retain old images if no new images are uploaded
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedFileExtensions = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');

            // Deleting old gallery images
            foreach (explode(',', $product->images) as $oldFile) {
                if (File::exists(public_path('uploads/products') . '/' . $oldFile)) {
                    File::delete(public_path('uploads/products') . '/' . $oldFile);
                }
                if (File::exists(public_path('uploads/products/thumbnails') . '/' . $oldFile)) {
                    File::delete(public_path('uploads/products/thumbnails') . '/' . $oldFile);
                }
            }

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $allowedFileExtensions)) {
                    $g_fileName = $current_timestamp . $counter . "." . $extension;
                    $this->GenerateProductThumbnailImage($file, $g_fileName);
                    $gallery_arr[] = $g_fileName;
                    $counter++;
                }
            }

            // If new images were uploaded, replace the old gallery images
            if (!empty($gallery_arr)) {
                $gallery_images = implode(',', $gallery_arr);
            }
        }

        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('product.index')->with('status', 'Product update successfully.');
    }
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }
        foreach (explode(',', $product->images) as $oldFile) {
            if (File::exists(public_path('uploads/products') . '/' . $oldFile)) {
                File::delete(public_path('uploads/products') . '/' . $oldFile);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $oldFile)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $oldFile);
            }
        }
        $product->delete();
        return redirect()->route('product.index')->with('status', 'Category Deleted Successfully');
    }
}