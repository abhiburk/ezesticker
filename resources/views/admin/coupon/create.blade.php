@extends('layouts.backend.app')
@section('title', 'Add Coupon')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{Request::is('*/edit') ? 'Edit':'Add'}} Coupon</h6>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if(Request::is('*/edit'))
                        <input type="hidden" name="coupon" value="{{ request()->coupon }}">
                    @endif
                
                    <div class="row">
                        <div class="form-group col-lg-6">
                            @php $field = 'name'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Coupon Name *</label>
                            <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $coupon->$field  }}" class="form-control" placeholder="eg. EZE10" required  {{ Request::is('*/edit')? 'readonly' : '' }}>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            @php $field = 'type'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Type *</label>
                            <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $coupon->$field  }}" class="form-control" placeholder="eg. discount" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            @php 
                            $field = 'target'; 
                            $target = ['total', 'subtotal'] 
                            @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Target *</label>
                            <select name="{{ $field }}" id="{{ $field }}" class="select2" required placeholer="Select an option">
                                    <option value="">Select an option</option>
                                @foreach ($target as $item)
                                    <option value="{{ $item }}" {{ old($field) ? ( old($field) == $item ? 'selected' : '' ) : 
                                        ($coupon->target==$item ? 'selected':'')  }} >
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            @php $field = 'value'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Coupon Value *</label>
                            <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $coupon->$field  }}" class="form-control" placeholder="eg. -10% or 100" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            @php $field = 'start_date'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Start Date *</label>
                            <input type="date" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $coupon->$field  }}" class="form-control" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            @php $field = 'end_date'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">End Date *</label>
                            <input type="date" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $coupon->$field  }}" class="form-control" required>
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
