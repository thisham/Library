<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll(): Collection
    {
        return $this->category->get();
    }

    public function getById($id)
    {
        return $this->category->where('id', $id)->first();
    }

    public function store($data): Category
    {
        $category = new $this->category;
        $category->name = $data['name'];

        $category->save();

        return $category;
    }

    public function update($data, $id): Category
    {
        $category = $this->category->find($id);
        $category->name = $data['name'];

        $category->update();

        return $category;
    }

    public function destroy($id): Category
    {
        $category = $this->category->find($id);
        $category->delete();

        return $category;
    }
}
