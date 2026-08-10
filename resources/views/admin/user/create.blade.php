@extends('layouts.backend.app')
@section('title', 'Create a User')
@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ Request::is('*/edit')?'Edit': 'Add' }} User</h6> 
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            
            <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(Request::is('*/edit'))
                    <input type="hidden" name="user_id" value="{{ request()->user }}">
                @endif
                
                <div class="row">
                    <div class="form-group col-lg-6">
                        @php $field = 'name'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Full Name *</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $user->$field  }}" class="form-control" placeholder="eg. Mike" required>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        @php $field = 'email'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Email-Id *</label>
                        <input type="email" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $user->$field  }}" class="form-control" placeholder="eg. mike@example.com" required {{ Request::is('*/edit')? 'disabled' : '' }}>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        @php $field = 'phone'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Mobile No.</label>
                        <input type="phone" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $user->$field  }}" class="form-control" placeholder="10 digit mobile no.">
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        @php $field = 'password'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Password</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ Request::is('*/edit')? '' : \Str::random(20) }}" class="form-control" placeholder="Secret password" {{ Request::is('*/edit')? '' : 'required' }}>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        @php $field = 'role'; @endphp
                        <label for="{{ $field }}" class="font-weight-bold">Roles *</label>
                        <select name="{{ $field }}[]" id="{{ $field }}" class="select2" required multiple placeholer="Select an option">
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}" {{ old($field) ? ( old($field) == $item->name ? 'selected' : '' ) : 
                                    (in_array($item->name, $user->roles->pluck('name')->toArray() ) ? 'selected':'')  }} >
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error($field)
                            <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    @if(Request::is('*/create'))
                        <small>An email will be sent with login credentials to the user</small>
                    @else 
                        <span></span>
                    @endif
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
