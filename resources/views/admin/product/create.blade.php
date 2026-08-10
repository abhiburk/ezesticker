@extends('layouts.backend.app')
@section('title', 'Create a Product')
@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-product-tab" data-toggle="pill" href="#product-tab" role="tab" aria-controls="pills-product" aria-selected="true">Product</a>
        </li>
        @if(Request::is('*/edit'))
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-price-tab" data-toggle="pill" href="#price-tab" role="tab" aria-controls="pills-price" aria-selected="false">Price</a>
            </li>
        
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-images-tab" data-toggle="pill" href="#images-tab" role="tab" aria-controls="pills-images" aria-selected="false">Images</a>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="product-tab" role="tabpanel" aria-labelledby="pills-product-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ Request::is('*/edit')?'Edit': 'Add' }} Product</h6> 
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(Request::is('*/edit'))
                            <input type="hidden" name="product_id" value="{{ request()->product }}">
                        @endif
                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                @php $field = 'name'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">Product Name *</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control" placeholder="eg. Smart Sticker" required>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                @php $field = 'sku'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">SKU *</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control" placeholder="eg. Unique SKU ID" required>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-12">
                                @php $field = 'description'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">Product Description</label>
                                <textarea name="{{ $field }}" id="{{ $field }}" class="form-control">{{ old($field)? old($field) : $product->$field  }}</textarea>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                @php $field = 'category_id'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">Product Category *</label>
                                <select name="{{ $field }}[]" id="{{ $field }}" class="select2" required multiple placeholer="Select an option">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ old($field) ? ( old($field) == $item->id ? 'selected' : '' ) : 
                                            ( in_array($item->id, $product->categories->pluck('category_id')->toArray()) ? 'selected':'')  }} >
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                @php $field = 'stock_status'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">Stock Status *</label>
                                
                                <select name="{{ $field }}" id="{{ $field }}" class="select2" required placeholer="Select an option">
                                    @foreach (Helper::stockStatus('object') as $item)
                                        <option value="{{ $item->value }}" 
                                            {{ old($field) ? ( old($field) == $item->name ? 'selected' : '' ) : 
                                            ( $item->name == $product->stock_status  ? 'selected':'')  }} >
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                @php $field = 'status'; @endphp
                                <label for="{{ $field }}" class="font-weight-bold">Product Status *</label>
                                
                                <select name="{{ $field }}" id="{{ $field }}" class="select2" required placeholer="Select an option">
                                    <option value="Active" 
                                        {{ old($field) ? ( old($field) == 'Active' ? 'selected' : '' ) : 
                                        ( 'Active' == $product->stock_status  ? 'selected':'')  }} >
                                        Active
                                    </option>
                                    <option value="In Active" 
                                        {{ old($field) ? ( old($field) == 'In Active' ? 'selected' : '' ) : 
                                        ( 'In Active' == $product->stock_status  ? 'selected':'')  }} >
                                        In Active
                                    </option>
                                </select>
                                @error($field)
                                    <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

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
                                @if(!empty($product->featured_image))
                                    <div class="alert alert-warning d-flex align-items-center justify-content-between mt-3" role="alert">
                                        <a href="{{ url('storage/'. $product->featured_image) }}" target="_blank" class="">
                                            <strong>{{ url('storage/'. $product->featured_image) }}</strong>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
        
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(Request::is('*/edit'))
            <div class="tab-pane fade" id="price-tab" role="tabpanel" aria-labelledby="pills-price-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Product Price</h6> 
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#productPriceModal">
                            <i class="fa fa-plus"></i> Price
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse">
                                <thead>
                                    <tr>
                                        <th>Price</th>
                                        <th>Date</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($product->prices as $item)
                                        <tr>
                                            <td scope="row">{{ $item->price }}</td>
                                            <td>{{ $item->start_date }} - {{ $item->end_date }}</td>
                                            <td>{{ $item->discount ?? "-" }}</td>
                                            <td>{{ $item->discount_type ?? "-" }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td class="d-flex align-items-center">
                                                <form class="delete-form" action="{{ route('product.delete_price', ['price' => Helper::encodeId($item->id)] ) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {!! csrf_field() !!}
                                                    <button type="button" class="btn btn-danger btn-sm confirm-delete"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty 
                                        <tr class="text-center">
                                            <td colspan="7">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="tab-pane fade" id="images-tab" role="tabpanel" aria-labelledby="pills-images-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Images</h6> 
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store_image') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ request()->product }}">
                            <div class="row">
                                <div class="form-group col-12">
                                    @php $field = 'image'; @endphp
                                    <div class="custom-file">
                                        <input type="file" name="{{ $field }}[]" class="custom-file-input" id="{{ $field }}" multiple>
                                        <label class="custom-file-label" for="{{ $field }}">Choose file</label>
                                    </div>
                                    @error('image')
                                        <small id="sub_title" class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if(isset($errors->getMessages()['image.0']))
                                        @foreach ($errors->getMessages()['image.0'] as $error)
                                            <small id="image" class="text-danger">{{ $error }}</small> <br>
                                        @endforeach
                                    @endif 
                                </div> 
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form> 
                    
                        @forelse ($product->media as $item)
                            <div class="alert alert-warning d-flex align-items-center justify-content-between mt-3" role="alert">
                                <strong>{{ $item->name }}</strong>
                                <div class="d-flex">
                                    <a href="{{ url('storage/'. $item->path) }}" target="_blank" class="btn btn-sm btn-info mr-2">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <form class="delete-form" action="{{ route('media.destroy', Helper::encodeId($item->id)) }}" method="POST">
                                        {{ method_field('DELETE') }}
                                        {!! csrf_field() !!}
                                        <button type="button" class="btn btn-danger btn-sm confirm-delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @empty @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productPriceModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="productPriceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('product.store_price') }}" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="productPriceLabel">Add Product Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    @csrf
                    @if(Request::is('*/edit'))
                        <input type="hidden" name="product_id" value="{{ request()->product }}">
                    @endif
                    
                    <div class="row">
                        <div class="form-group col-lg-12">
                            @php $field = 'price'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Product Price *</label>
                            <input type="number" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            @php $field = 'discount'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Product Discount</label>
                            <input type="number" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control">
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            @php $field = 'discount_type'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Discount Type</label>
                            
                            <select name="{{ $field }}" id="{{ $field }}" class="select2" placeholer="Select an option">
                                <option value="">Select an option</option>
                                <option value="Regular" 
                                    {{ old($field) ? ( old($field) == 'Regular' ? 'selected' : '' ) : 
                                    ( 'Regular' == $product->discount_type  ? 'selected':'')  }} >
                                    Regular
                                </option>
                                <option value="Percentage" 
                                    {{ old($field) ? ( old($field) == 'Percentage' ? 'selected' : '' ) : 
                                    ( 'Percentage' == $product->discount_type  ? 'selected':'')  }} >
                                    Percentage
                                </option>
                            </select>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            @php $field = 'start_date'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Start Date</label>
                            <input type="date" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            @php $field = 'end_date'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">End Date</label>
                            <input type="date" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : $product->$field  }}" class="form-control" required>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#productPriceModal').modal('show');
        @endif

        // Javascript to enable link to tab
        var hash = location.hash.replace(/^#/, '');  // ^ means starting, meaning only match the first hash
        if (hash) {
            $('.nav-pills a[href="#' + hash + '"]').tab('show');
        } 

        // Change hash for page-reload
        $('.nav-pills a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        })
    </script>
@endpush
