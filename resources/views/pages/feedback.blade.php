@extends('layouts.frontend.app')
@section('title', 'Customer Feedback')
@section('content')
    <div class="container">
        <div class="row my-5 d-flex justify-content-center">
            <div class="col-lg-7 col-sm-12">
                @livewire('utils.customer-feedback-form', ['source' => request()->source])
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .success-icon{
            font-size: 8em;
        }
        @media (max-width: 992px) {
            .success-icon{
                font-size: 5em;
            }
        }
        .feedback__textarea textarea {
            border: 1px solid rgba(196, 196, 196, 0.5);
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            /* font-family: "Inter", san-serif; */
            margin: 10px 0;
            padding: 10px;
            resize: none;
        }

        .feedback__textarea label {
            color: #C4C4C4;
            font-size: 13px;
            font-style: italic;
            font-weight: 300;
            margin-bottom: 15px;
        }
    </style>
@endpush
