@extends('layouts.backend.app')
@section('title', 'Create a Faq')
@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ Request::is('*/edit')?'Edit': 'Add' }} Faq</h6> 
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            
            <form action="{{ route('faq.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(Request::is('*/edit'))
                    <input type="hidden" name="faq_id" value="{{ request()->faq }}">
                @endif
                
                <div class="row">
                    <div class="form-group col">
                        @php $field = 'title'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Title *</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $faq->$field  }}" class="form-control" required>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>  
                    <div class="form-group col">
                        @php $field = 'type'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">FAQ Type</label>
                        <select name="{{ $field }}" class="custom-select">
                            <option value="">Select option</option>
                            @foreach (Helper::getFaqTypes() as $item)
                                <option {{ $faq->type == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        @php $field = 'description'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Content</label>
                        <textarea id="editor" name="{{ $field }}">{!! old($field)? old($field) : $faq->$field !!} </textarea>
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
