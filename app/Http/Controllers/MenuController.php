<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Constants\MenuCategory;
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
        $categories = MenuCategory::all();

        $query = MenuItem::query();

        if ($category && MenuCategory::exists($category)) {
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

        $categories = MenuCategory::all();

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
            'category' => 'required|' . MenuCategory::validationRule(),
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'image_url' => 'nullable|url',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $filename = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('menu_images', $filename, 'public');
            $validated['image'] = $filename;
        }

        $menuItem = MenuItem::create($validated);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu item created successfully!',
                'menu_item' => $menuItem
            ]);
        }

        return redirect()->route('menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Display the specified menu item.
     */
    public function show(Request $request, MenuItem $menuItem)
    {
        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json($menuItem);
        }
        
        return view('menu.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem)
    {
        Gate::authorize('update-menu');

        $categories = MenuCategory::all();

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
            'category' => 'required|' . MenuCategory::validationRule(),
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'image_url' => 'nullable|url',
            'delete_image' => 'boolean',
        ]);

        // Handle image deletion
        if (isset($validated['delete_image']) && $validated['delete_image']) {
            $menuItem->deleteImage();
            $validated['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            $menuItem->deleteImage();
            
            $imageFile = $request->file('image');
            $filename = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('menu_images', $filename, 'public');
            $validated['image'] = $filename;
        }

        $menuItem->update($validated);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu item updated successfully!',
                'menu_item' => $menuItem
            ]);
        }

        return redirect()->route('menu.show', $menuItem)
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item from database.
     */
    public function destroy(MenuItem $menuItem, Request $request)
    {
        Gate::authorize('delete-menu');

        // Delete associated image
        $menuItem->deleteImage();

        $menuItem->delete();

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu item deleted successfully!'
            ]);
        }

        return redirect()->route('menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }
    
    /**
     * API endpoint for POS to get menu items
     */
    public function apiIndex(Request $request)
    {
        $category = $request->query('category');
        
        $query = MenuItem::where('is_available', true);
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $menuItems = $query->orderBy('category')->orderBy('name')->get();
        
        return response()->json([
            'menu_items' => $menuItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'category' => $item->category,
                    'image_url' => $item->image_url,
                    'stock' => $item->stock,
                    'is_available' => $item->is_available,
                ];
            })
        ]);
    }
}
