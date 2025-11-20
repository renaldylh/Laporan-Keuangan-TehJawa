<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of menu items with filtering by category.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $categories = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        $query = MenuItem::query();

        if ($category && array_key_exists($category, $categories)) {
            $query->where('category', $category);
        }

        $menuItems = $query->paginate(15);

        return view('menu.index', compact('menuItems', 'categories', 'category'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        Gate::authorize('create-menu');

        $categories = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        return view('menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu item in database.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-menu');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:menu_items',
            'description' => 'nullable|string|max:500',
            'category' => 'required|in:paket,gyutan,dori,salmon,nasi_goreng,mie_bihun,snack,minuman',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1',
        ]);

        MenuItem::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Display the specified menu item.
     */
    public function show(MenuItem $menuItem)
    {
        return view('menu.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem)
    {
        Gate::authorize('update-menu');

        $categories = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        return view('menu.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified menu item in database.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        Gate::authorize('update-menu');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:menu_items,name,' . $menuItem->id,
            'description' => 'nullable|string|max:500',
            'category' => 'required|in:paket,gyutan,dori,salmon,nasi_goreng,mie_bihun,snack,minuman',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1',
        ]);

        $menuItem->update($validated);

        return redirect()->route('menu.show', $menuItem)
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item from database.
     */
    public function destroy(MenuItem $menuItem)
    {
        Gate::authorize('delete-menu');

        $menuItem->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}
