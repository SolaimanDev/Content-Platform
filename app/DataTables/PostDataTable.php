<?php

namespace App\DataTables;

use App\Models\Post;
use App\Models\Category;
use App\Helpers\ImageHelper;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class PostDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query): EloquentDataTable
    {
        //  return (new EloquentDataTable($query))
        //     // ->addColumn('action', 'category.action')
        //     ->setRowId('id');
            
        return (new EloquentDataTable($query))
            ->addColumn('action', function($post) {
                return view('admin.post.action', compact('post'))->render();
            })
             ->addColumn('image', function (Post $post) {
               $img=  ImageHelper::getUrl($post->image);
                return $post->image
                    ? '<img src="'.asset('storage/'.$post->image).'" alt="Thumbnail" class="img-thumbnail" width="80">'
                    : '<span class="text-muted">No thumbnail</span>';
            })
            ->editColumn('title', function($post) {
                return '<a href="'.route('admin.posts.show', $post->id).'">'.$post->title.'</a>';
            })
            ->editColumn('status', function (Post $post) {
                return $this->getStatusBadge($post->status);
            })
            ->editColumn('created_at', function($post) {
                return $post->created_at->format('d M Y, h:i A');
            })
            ->rawColumns(['action', 'title', 'image',  'status'])
            ->setRowId('id');
    }

        protected function getStatusBadge(int $status): string
    {
        $statuses = [
            0 => ['text' => 'Pending', 'class' => 'bg-secondary'],
            1 => ['text' => 'Active', 'class' => 'bg-success'],
            2 => ['text' => 'Inactive', 'class' => 'bg-warning'],
            3 => ['text' => 'Archived', 'class' => 'bg-danger']
        ];

        return '<span class="badge '.$statuses[$status]['class'].'">'
             .$statuses[$status]['text']
             .'</span>';
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['category', 'user'])
            ->select('posts.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('post-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>B')
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel')->className('btn btn-success'),
                // Button::make('csv')->className('btn btn-primary'),
                // Button::make('pdf')->className('btn btn-danger'),
                // Button::make('print')->className('btn btn-info'),
                // Button::make('reset')->className('btn btn-secondary'),
                // Button::make('reload')->className('btn btn-warning')
            ])
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('#')->width(50),
            Column::make('title')->title('Post Title'),
            Column::make('category.name')->title('Category')->orderable(false),
            Column::make('user.name')->title('Author')->orderable(false),
            Column::make('status')->title('Status'),
            Column::make('image')->title('Thumbnail'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->title('Actions')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
               
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Posts_' . date('YmdHis');
    }
}
