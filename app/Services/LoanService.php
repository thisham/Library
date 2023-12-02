<?php

namespace App\Services;

use App\Models\Loan;
use App\Repositories\LoanRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class LoanService
{
    protected $LoanRepository;

    public function __construct(LoanRepository $LoanRepository)
    {
        $this->LoanRepository = $LoanRepository;
    }

    public function getAll(): Collection
    {
        return $this->LoanRepository->getAll();
    }

    public function getById($id): Loan
    {
        return $this->LoanRepository->getById($id);
    }

    public function store($data)
    {
        $validator = Validator::make($data, [
            'book_copy_id' => 'required|exists:book_copies,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected,returned',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $loan = $this->LoanRepository->store($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to create data');
        }
        DB::commit();

        return $loan;
    }

    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'book_copy_id' => 'required|exists:book_copies,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected,returned',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        DB::beginTransaction();
        try {
            $loan = $this->LoanRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update data');
        }
        DB::commit();

        return $loan;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->LoanRepository->destroy($id);
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => 'Loan data']);
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
