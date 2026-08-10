@extends('layouts.frontend.app')
@section('title', 'My Wallet: ' . auth()->user()->name)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5">
            <div class="row">
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    <div class="row justify-content-end">
                        <div class="col-lg-6 col-12">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="m-0 text-center"><i class="fas fa-wallet"></i> Wallet Balance: {{ INR }}{{ auth()->user()->wallet->balanceFloat }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table shadow-sm table-bordered bg-white">
                            <thead>
                                <tr>
                                    <th scope="col">Source</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">
                                        Logs
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $item)
                                    <tr>
                                        <td>{{ isset($item->meta['created_by']) ? \App\Models\User::find($item->meta['created_by'])->name : '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-F-Y') }}</td>
                                        <td>{{ INR }}{{ round($item->amountFloat,2) }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>
                                            {{ isset($item->meta['message']) ? $item->meta['message'] : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">
                                            You don't have any wallet transactions. <br>
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="float-right">
                        {{ $transactions->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
