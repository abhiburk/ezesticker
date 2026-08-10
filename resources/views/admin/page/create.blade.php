@extends('layouts.backend.app')
@section('title', 'Create a Page')
@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ Request::is('*/edit')?'Edit': 'Add' }} Page</h6> 
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            
            <form action="{{ route('page.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(Request::is('*/edit'))
                    <input type="hidden" name="page_id" value="{{ request()->page }}">
                @endif
                
                <div class="row">
                    <div class="form-group col-lg-12">
                        @php $field = 'title'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Title *</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $page->$field  }}" class="form-control" required>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>  
                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        @php $field = 'content'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Content</label>
                        <textarea id="editor" name="{{ $field }}">{!! old($field)? old($field) : $page->$field !!} </textarea>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        @php $field = 'excerpt'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Summary/Excerpt</label>
                        <textarea type="text" name="{{ $field }}" id="{{ $field }}"  class="form-control">{{ old($field)? old($field) : $page->$field  }}</textarea>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> 
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        @php $field = 'featured_image'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Featured Image</label>
                        <div class="custom-file">
                            <input type="file" name="{{ $field }}" class="custom-file-input" id="{{ $field }}">
                            <label class="custom-file-label" for="{{ $field }}">Choose file</label>
                        </div>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                        @if(!empty($page->featured_image))
                            <div class="alert alert-warning d-flex align-items-center justify-content-between mt-3" role="alert">
                                <a href="{{ url('storage/'. $page->featured_image) }}" target="_blank" class="">
                                    <strong>{{ url('storage/'. $page->featured_image) }}</strong>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-lg-6">
                        @php $field = 'slug'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Slug</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $page->$field  }}" class="form-control">
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>  
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
