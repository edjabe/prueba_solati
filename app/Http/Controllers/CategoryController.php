<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $categories = Category::query()->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        return response()->json(['results' => count($categories), 'categories' => $categories], 200);
    }

    public function products()
    {
        try {
            $categories = Category::query()->with(['products'])->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        return response()->json(['results' => count($categories), 'categories' => $categories], 200);
    }
}
