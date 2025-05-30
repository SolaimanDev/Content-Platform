@extends('layouts.app')
@section('content')
     <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Post List</h6>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-right">Create User</a>
        </div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered']) !!}
        </div>
    </div>
@endsection


@push('style')
@include('admin.includes.styles.datatable')
<style>
.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    border-radius: 0.25rem;
}
.bg-secondary { background-color: #6c757d; }
.bg-success { background-color: #198754; }
.bg-warning { background-color: #ffc107; color: #000; }
.bg-danger { background-color: #dc3545; }
</style>
@endpush

@push('script')
@include('admin.includes.scripts.datatable')
<script>
	$(document).ready(function () {
    $(".dataTable").wrap("<div class='table-responsive w-100'></div>");
    });
</script>
@endpush