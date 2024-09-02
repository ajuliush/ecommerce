<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slider::query();

        if ($request->has('search')) {
            $query->where('code', 'like', '%' . $request->input('search') . '%');
        }

        $sliders = $query->orderBy('id', 'DESC')->paginate(10);
        return view('backend.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'subtitle' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'link' => 'required',
            'status' => 'required'
        ]);
        $slider =  new Slider();
        $slider->tagline = $request->tagline;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->link = $request->link;
        $slider->status = $request->status;

        // Check if an image file is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSliderThumbnailsImage($image, $file_name);
            $slider->image = $file_name;
        } else {
            $slider->image = null; // or set a default image if needed
        }
        $slider->save();
        return redirect()->route('slider.index')->with('status', 'Slider created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'subtitle' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'link' => 'required',
            'status' => 'required'
        ]);
        $slider =   Slider::findOrFail($id);
        $slider->tagline = $request->tagline;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->link = $request->link;
        $slider->status = $request->status;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/sliders') . '/' . $slider->image)) {
                File::delete(public_path('uploads/sliders') . '/' . $slider->image);
            }
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSliderThumbnailsImage($image, $file_name);
            $slider->image = $file_name;
        }
        $slider->save();
        return redirect()->route('slider.index')->with('status', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $slider = Slider::findOrFail($request->id);
        if (File::exists(public_path('uploads/sliders') . '/' . $slider->image)) {
            File::delete(public_path('uploads/sliders') . '/' . $slider->image);
        }
        $slider->delete();
        return redirect()->route('slider.index')->with('status', 'Slider Deleted Successfully');
    }

    public function GenerateSliderThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/sliders');
        $img = Image::read($image->path());
        $img->cover(400, 690, 'top');
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($destinationPath . '/' . $imageName);
    }
}
