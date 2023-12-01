<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Collection;

class BookRepository
{
    protected $book;
    protected $bookCopy;

    public function __construct(Book $book, BookCopy $bookCopy)
    {
        $this->book = $book;
        $this->bookCopy = $bookCopy;
    }

    public function getAll(): Collection
    {
        return $this->book->get();
    }

    public function getById($id)
    {
        return $this->book->with('authors', 'categories')->where('id', $id)->first();
    }

    public function store($data): Book
    {
        $book = new $this->book;
        $book->title = $data['title'];
        $book->publisher = $data['publisher'];
        $book->published_year = $data['published_year'];
        $book->isbn = $data['isbn'];
        $book->language = $data['language'];
        $book->pages = $data['pages'];

        if (!empty($data['cover_image'])) {
            $imageName = $data['cover_image']->hashName();
            $data['cover_image']->move(public_path('uploads/img_books'), $imageName);
            $book->cover_image = $imageName;
        }

        $book->save();
        $book->authors()->sync($data['authors']);
        $book->categories()->sync($data['categories']);

        return $book;
    }

    public function storeBookCopies(Book $book, int $quantity): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $bookCopy = new $this->bookCopy;
            $bookCopy->book()->associate($book);
            $bookCopy->save();
        }
    }

    public function update($data, $id): Book
    {
        $book = $this->book->find($id);
        $book->title = $data['title'];
        $book->publisher = $data['publisher'];
        $book->published_year = $data['published_year'];
        $book->isbn = $data['isbn'];
        $book->language = $data['language'];
        $book->pages = $data['pages'];

        if (!empty($data['cover_image'])) {
            $imageName = $book->getAttribute('cover_image');
            if (!empty($imageName) && file_exists("uploads/img_books/" . $imageName)) {
                unlink('uploads/img_books/' . $imageName);
            }
            $imageName = $data['cover_image']->hashName();
            $data['cover_image']->move(public_path('uploads/img_books'), $imageName);
            $book->cover_image = $imageName;
        }

        $book->update();
        $book->authors()->sync($data['authors']);
        $book->categories()->sync($data['categories']);
        $book->touch();

        return $book;
    }

    public function destroy($id): Book
    {
        $book = $this->book->find($id);
        $book->categories()->detach();
        $book->authors()->detach();
        $imageName = $book->getAttribute('cover_image');
        if (!empty($imageName) && file_exists("uploads/img_books/" . $imageName)) {
            unlink('uploads/img_books/' . $imageName);
        }
        $book->delete();

        return $book;
    }
}
