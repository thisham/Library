<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository
{
    protected $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function getAll(): Collection
    {
        return $this->author->get();
    }

    public function getById($id)
    {
        return $this->author->where('id', $id)->first();
    }

    public function store($data): Author
    {
        $author = new $this->author;
        $author->name = $data['name'];

        $author->save();

        return $author;
    }

    public function update($data, $id): Author
    {
        $author = $this->author->find($id);
        $author->name = $data['name'];

        $author->update();

        return $author;
    }

    public function destroy($id): Author
    {
        $author = $this->author->find($id);
        $author->delete();

        return $author;
    }
}
