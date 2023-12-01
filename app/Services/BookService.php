<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getAll(): Collection
    {
        return $this->bookRepository->getAll();
    }

    public function getById($id): Book
    {
        return $this->bookRepository->getById($id);
    }

    public function store($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'authors' => 'required|array|exists:authors,id',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|digits:4|min:1901|max:' . date('Y'),
            'categories' => 'required|array|exists:categories,id',
            'isbn' => ['nullable', 'unique:books', new \App\Rules\ISBN],
            'language' => 'required|in:Indonesia,Arab,Inggris',
            'pages' => 'required|integer',
            'cover_image' => 'image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $book = $this->bookRepository->store($data);
            $quantity = $data['quantity'] ?? 1;
            $this->bookRepository->storeBookCopies($book, $quantity);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            return ['error' => 'Unable to add data'];
        }
        DB::commit();

        return $book;
    }

    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'authors' => 'required|array|exists:authors,id',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|digits:4|min:1901|max:' . date('Y'),
            'categories' => 'required|array|exists:categories,id',
            'isbn' => ['nullable', Rule::unique('books', 'isbn')->ignore($id), new \App\Rules\ISBN],
            'language' => 'required|in:Indonesia,Arab,Inggris',
            'pages' => 'required|integer',
            'cover_image' => 'image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $book = $this->bookRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            return ['error' => 'Unable to update data'];
        }
        DB::commit();

        return $book;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->bookRepository->destroy($id);
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => 'Book data']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            $status = 'errors';
            $message = $e->getMessage();
        }
        DB::commit();

        return ['status' => $status, 'message' => $message];
    }
}
