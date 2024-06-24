<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Content\PagesRequest;
use App\Http\Requests\Backend\Content\PagesUpdateRequest;
use App\Models\Content\Category;
use App\Models\Content\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.content.pages.index', [
            'pages' => Pages::with('Category')->orderBy('id','DESC')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = new Pages();
        return view('backend.content.pages.form', [
            'pages' => $pages,
            'categories_list' => Category::all()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|string|unique:content_pages',
            'slug' => 'min:3|max:255|string',
            'category_id' => 'nullable',
            'description' => 'max:255',
            'content' => 'min:3|string',
            'is_menu' => '',
            'active' => '',
        ]);
        @$validated['is_menu'] = $validated['is_menu']=='on' ? 1:0;
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        if($validated['category_id']) {
            $slugCategory = Category::where('id', '=', $validated['category_id'])->pluck('slug')->first();
            $validated['slug'] = $slugCategory.'/'.Str::slug($validated['name']);
        } else {
            $validated['slug'] = '/'.Str::slug($validated['name']);
        }
        $validated['user_id'] = auth()->id();
        Pages::create($validated);
        return redirect()->route('backend.content.pages.index')->withSuccess('Page ajoutée avec succès');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pages $page)
    {
        return view('backend.content.pages.form', [
            'pages' => $page,
            'categories_list' => Category::all()
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pages $page)
    {

        $validated = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'slug' => 'min:3|max:255|string',
            'category_id' => 'nullable',
            'description' => 'max:255',
            'content' => 'min:3|string',
            'is_menu' => '',
            'active' => '',
        ]);
        @$validated['is_menu'] = $validated['is_menu']=='on' ? 1:0;
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        if($validated['category_id']) {
            $slugCategory = Category::where('id', '=', $validated['category_id'])->pluck('slug')->first();
            $validated['slug'] = $slugCategory.'/'.Str::slug($validated['name']);
        } else {
            $validated['slug'] = '/'.Str::slug($validated['name']);
        }
        if($page->id == 1) { $validated['slug'] = "/"; }
        $validated['user_id_update'] = auth()->id();
        Pages::where('id', $page->id)->update($validated);
        return back()->withSuccess('Page modifiée avec succès');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pages $page)
    {
        if($page->id != '1') {
            $page->delete();
            return back()->withSuccess('Page supprimée avec succès');
        } else {
            return back()->withErrors('Vous ne pouvez pas supprimer la page d\'accueil.');

        }
    }
}
