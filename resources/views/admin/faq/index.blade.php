@extends('layouts.backend.app')
@section('title', 'All Faq')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('faq.create') }}" class="btn btn-primary">
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
                    <h6 class="m-0 font-weight-bold text-primary">All Faqs</h6> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-inverse">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faqs as $item)
                                    <tr>
                                        <td scope="row">{{ $item->title }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('faq.edit', ['faq' => Helper::encodeId($item->id)] ) }}" class="btn btn-link">Edit</a>
                                            |
                                            <form class="delete-form" action="{{ route('faq.destroy', ['faq' => Helper::encodeId($item->id)] ) }}" method="POST">
                                                {{ method_field('DELETE') }}
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                                <button type="button" class="btn btn-link confirm-delete">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty 
                                    <tr class="text-center">
                                        <td colspan="4">No Faq</td>
                                    </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
