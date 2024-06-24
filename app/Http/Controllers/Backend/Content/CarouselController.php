<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Controllers\Controller;
use App\Models\Content\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.content.carousel.index', [
            'sliders' => Carousel::select('id', 'name', 'image', 'active')->orderBy('id','ASC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carrousel = new Carousel();
        return view('backend.content.carousel.form', [
            'slide' => $carrousel,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:content_carousel|max:255',
            'description' => 'string|max:255|nullable',
            'title_url' => 'string|max:255|nullable',
            'url' => 'string|max:255|nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
        $validated['image']->storeAs('public/upload/content/carousel', $imageName);
        $validated['image'] = $imageName;
        Carousel::create($validated);
        return redirect()->route('backend.content.carrousel.index')->withSuccess('Image du carrousel ajouter avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carrousel)
    {
        return view('backend.content.carousel.form', [
            'slide' => $carrousel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carousel $carrousel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255|nullable',
            'title_url' => 'string|max:255|nullable',
            'url' => 'string|max:255|nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        if(@$validated['image']){
            /*** Suppresion de l'ancienne image ***/
            $imgold = Carousel::select('image')->where('id', $carrousel->id)->first();
            Storage::delete('public/upload/content/carousel/'.$imgold->image);
            /*** ***/
            $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
            $validated['image']->storeAs('public/upload/content/carousel/', $imageName);
            $validated['image'] = $imageName;
            Carousel::where('id', $carrousel->id)->update($validated);
            return back()->withSuccess('Image modifiée avec succès');
        } else {
            Carousel::where('id', $carrousel->id)->update($validated);
            return back()->withSuccess('Image modifiée avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carrousel)
    {
        Storage::delete('public/upload/content/carousel/'.$carrousel->image);
        $carrousel->delete();
        return back()->withSuccess('Image supprimée avec succès');
    }
}
