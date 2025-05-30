@extends('layouts.app')
@section('content')
     <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
        </div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered']) !!}
        </div>
    </div>
@endsection


@push('style')
@include('admin.includes.styles.datatable')
@endpush

@push('script')
@include('admin.includes.scripts.datatable')
<script>
	$(document).ready(function () {
    $(".dataTable").wrap("<div class='table-responsive w-100'></div>");
    });
</script>
@endpush