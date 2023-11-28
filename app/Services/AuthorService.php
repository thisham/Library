<?php

namespace App\Services;

use App\Models\Author;
use App\Repositories\AuthorRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AuthorService
{
    protected $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function getAll(): Collection
    {
        return $this->authorRepository->getAll();
    }

    public function getById($id): Author
    {
        return $this->authorRepository->getById($id);
    }

    public function store($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $author = $this->authorRepository->store($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to create data');
        }
        DB::commit();

        return $author;
    }

    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $author = $this->authorRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update data');
        }
        DB::commit();

        return $author;
    }

    public function destroy($id): string
    {
        DB::beginTransaction();
        try {
            $this->authorRepository->destroy($id);
            $status = 'success';
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            $status = 'errors';
        }
        DB::commit();

        return $status;
    }
}
