@extends('layouts.backend.app')
@section('title', 'All Products')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('product.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Products</h6> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-inverse">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Featured Image</th>
                                    <th>Stock Status</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $item)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>
                                            <a href="{{ url('storage/'. $item->featured_image) }}" target="_blank">
                                                <img src="{{ url('storage/'. $item->featured_image) }}" alt="Featured Image" width="50">
                                            </a>
                                        </td>
                                        <td>{{ $item->stock_status }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('product.edit', ['product' => Helper::encodeId($item->id)] ) }}" class="btn btn-primary btn-sm mr-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form class="delete-form" action="{{ route('product.destroy', ['product' => Helper::encodeId($item->id)] ) }}" method="POST">
                                                {{ method_field('DELETE') }}
                                                {!! csrf_field() !!}
                                                <button type="button" class="btn btn-danger btn-sm confirm-delete"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty 
                                    <tr class="text-center">
                                        <td colspan="9"></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(function(){
            $('.confirm-delete').click(function(){
                if(confirm('Are you sure?')){
                    $('.delete-form').submit();
                }
            });
        });
    </script>
@endpush
