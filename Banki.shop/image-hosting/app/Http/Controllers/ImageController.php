<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('upload_time', 'desc')->get();
        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('images.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/images', $image, $filename);

                Image::create([
                    'filename' => $filename,
                    'upload_time' => now()
                ]);
            }
        }

        return redirect()->route('images.index');
    }

    public function show($id)
    {
        $image = Image::findOrFail($id);
        return response()->json($image);
    }

    public function imagesJson()
    {
        $images = Image::all();
        return response()->json($images);
    }
}
