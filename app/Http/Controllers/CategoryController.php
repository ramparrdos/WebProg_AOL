<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $categories = Category::forUser($userId)->get();

        return view('categories.index', compact('categories'));
    }

    public function create(){
        return view('categories.form');
    }

    public function store(StoreCategoryRequest $request){
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category has been created successfully!');
    }

    public function edit(Category $category){
        return view('categories.form', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category){
        if($category->user_id !== null && $category->user_id !== Auth::id()){
            abort(403, 'Unauthorized action.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
