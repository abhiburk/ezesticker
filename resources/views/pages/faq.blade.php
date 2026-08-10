@extends('layouts.frontend.app')
@section('title', 'FAQ')
@section('content')
    <div class="container">
        <div class="row mb-5">
            @foreach ($faqs as $key => $faq)
                <div class="col-12 text-center  my-5">
                    <h1 class="text-responsive font-weight-bold d-block">{{ $key }}</h1>
                </div>
                <div class="col-12">
                    <div class="accordion shadow" id="accordionExample">
                        @foreach ($faq as $key_1 => $item)
                            <div class="card ">
                                <div class="card-header  bg-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-block text-left shadow-none text-dark" type="button" data-toggle="collapse"
                                            data-target="#{{ $key.'_'.$key_1 }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ $key.'_'.$key_1 }}">
                                            <i class="bi bi-chevron-{{ $loop->first ? 'down' : 'right' }}"></i>
                                            <strong>{{ $item->title }}</strong>
                                        </button>
                                    </h2>
                                </div>

                                <div id="{{ $key.'_'.$key_1 }}" class="collapse {{ $loop->first ? 'show' : '' }}  bg-light" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        {!! $item->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function(){
            $('[data-toggle="collapse"]').on('click', function(){
                if ($(this).attr('aria-expanded') == 'true') {
                    $(this).find('i').addClass('bi-chevron-right').removeClass('bi-chevron-down');
                } else {
                    $(this).find('i').addClass('bi-chevron-down').removeClass('bi-chevron-right');
                }
            });
        });
    </script>
@endpush