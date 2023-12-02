<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;

class LoanRepository
{
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function getAll(): Collection
    {
        return $this->loan->get();
    }

    public function getById($id)
    {
        return $this->loan->with('users', 'bookCopy')->where('id', $id)->first();
    }

    public function store($data): Loan
    {
        $loan = new $this->loan;
        $loan->book_copy_id = $data['book_copy_id'];
        $loan->user_id = $data['user_id'];
        $loan->loan_date = $data['loan_date'];
        $loan->return_date = $data['return_date'];
        $loan->status = $data['status'];
        $loan->save();

        return $loan;
    }

    public function update($data, $id): Loan
    {
        $loan = $this->loan->find($id);
        $loan->book_copy_id = $data['book_copy_id'];
        $loan->user_id = $data['user_id'];
        $loan->loan_date = $data['loan_date'];
        $loan->return_date = $data['return_date'];
        $loan->status = $data['status'];
        $loan->update();

        return $loan;
    }

    public function destroy($id): Loan
    {
        $loan = $this->loan->find($id);
        $loan->delete();

        return $loan;
    }
}
