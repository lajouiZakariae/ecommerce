<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->user->categories;
    }

    public function products($categoryId)
    {
        return ProductResource::collection($this->user->products()->whereCategoryId($categoryId)->get());
    }

    public function storeProduct(ProductPostRequest $request,  $categoryId)
    {
        $data = $request->validated();

        $data["category_id"] = $categoryId;

        return $this->user->products()->create($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(["slug" => Str::slug($request->input("name"))]);

        $data = $request->validate([
            "name" => "required",
            "slug" => ["required", "unique:categories"]
        ]);

        return $this->user->categories()->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        return $this->user->categories()->find($categoryId) ?? abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $categoryId)
    {
        $request->merge(["slug" => Str::slug($request->input("name"))]);

        $data = $request->validate([
            "name" => "required",
            "slug" => ["required", "unique:categories"]
        ]);

        return $this->user->categories()->whereId($categoryId)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        // Assigning Products to Default Category
        $this->user->products()->where("category_id", $categoryId)->update([
            "category_id" => $this->user->defaultCategory->id
        ]);

        return $this->user->categories()->whereId($categoryId)->delete();
    }
}
