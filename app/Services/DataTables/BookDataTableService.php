<?php

namespace App\Services\DataTables;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BookDataTableService extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('cover_image', function ($book) {
                $url = $book->cover_image ? asset("uploads/img_books/$book->cover_image") : asset('images/error/no_cover.png');
                return '<img src=' . $url . ' class="img-rounded" style="max-width: 100px" align="center"/>';
            })
            ->addColumn('authors', function (Book $book) {
                $author = $book->authors->map(function ($author) {
                    return '<span class="text-capitalize badge bg-primary mb-2">' . $author->name . '</span>';
                })->implode('<br>');
                return $author;
            })
            ->addColumn('categories', function (Book $book) {
                $category = $book->categories->map(function ($category) {
                    return '<span class="text-capitalize badge bg-primary mb-2">' . $category->name . '</span>';
                })->implode('<br>');
                return $category;
            })
            ->addColumn('action', 'admin.book.action')
            ->rawColumns(['action', 'cover_image', 'authors', 'categories']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Book $model): QueryBuilder
    {
        return $model->newQuery()->with('categories');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('books-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(0, 'asc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('cover_image')
                ->orderable(false)
                ->searchable(false)
                ->width(100),
            Column::make('title'),
            Column::make('authors')
                ->title('Author')
                ->width(80),
            Column::make('publisher'),
            Column::make('published_year'),
            Column::make('categories')->title('Category'),
            Column::make('isbn')->title('ISBN'),
            Column::make('language'),
            Column::make('pages'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Books' . date('YmdHis');
    }
}
