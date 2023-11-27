<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getById($id): Category
    {
        return $this->categoryRepository->getById($id);
    }

    public function store($data): Category
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $product = $this->categoryRepository->store($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to create data');
        }
        DB::commit();

        return $product;
    }

    public function update($data, $id): Category
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $product = $this->categoryRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update data');
        }
        DB::commit();

        return $product;
    }

    public function destroy($id): Category
    {
        DB::beginTransaction();
        try {
            $product = $this->categoryRepository->destroy($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete data');
        }
        DB::commit();

        return $product;
    }
}
