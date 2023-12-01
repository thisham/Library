<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    public function getAuthors(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $authors = Author::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $authors = Author::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = [];
        foreach ($authors as $author) {
            $response[] = [
                "id" => $author->id,
                "text" => $author->name
            ];
        }

        return response()->json($response);
    }

    public function getCategories(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $categories = Category::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $categories = Category::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = [];
        foreach ($categories as $category) {
            $response[] = [
                "id" => $category->id,
                "text" => $category->name
            ];
        }

        return response()->json($response);
    }
}
