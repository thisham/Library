<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\User;
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

    public function getBooks(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $books = BookCopy::orderby('id', 'asc')->select('id', 'book_id')->with('books')->limit(5)->get();
        } else {
            $books = BookCopy::orderby('id', 'asc')->select('id', 'book_id')->where('id', 'like', '%' . $search . '%')->with('books')->limit(5)->get();
        }

        $response = [];

        foreach ($books as $book) {
            $response[] = [
                "id" => $book->id,
                "text" => $book->books->title
            ];
        }

        return response()->json($response);
    }

    public function getUsers(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $users = User::orderby('id', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $users = User::orderby('id', 'asc')->select('id', 'name')->where('id', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = [];

        foreach ($users as $user) {
            $response[] = [
                "id" => $user->id,
                "text" => $user->name
            ];
        }

        return response()->json($response);
    }
}
