<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $s_products = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $f_products = Product::where('featured', 1)->inRandomOrder()->get()->take(8);
        return view('frontend.index', compact('sliders', 'categories', 's_products', 'f_products'));
    }

    public function contact_us()
    {
        return view('frontend.contact');
    }
    public function contact_us_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'comment' => 'required',
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('status', 'Your message has been sent successfully.');
    }
    public function search(Request $request)
    {
       $search = $request->input('query');
       $products = Product::where('name', 'like', "%{$search}%")->get()->take(8);
        return response()->json($products);
    }
}