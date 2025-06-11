@extends('admin.master')

@section('title', __('messages.view_sale'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ __('messages.view_sale') }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">{{ __('messages.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('sales.index') }}" class="text-primary text-decoration-none">{{ __('messages.sales') }}</a>
                </li>
                <li class="breadcrumb-item active text-muted">{{ __('messages.view') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">{{ __('messages.sale_details') }}</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">{{ __('messages.total_amount') }}</label>
                                <div>{{ number_format($sale->total_amount, 2) }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">{{ __('messages.status') }}</label>
                                <div>
                                    <span class="badge
                                        {{ $sale->status == 'completed' ? 'bg-success' :
                                           ($sale->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">{{ __('messages.date') }}</label>
                                <div>{{ $sale->date ?? '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                           <label class="form-label fw-medium">{{ __('messages.customer') }}</label>
                                <div>{{ $sale->customer->name ?? 'N/A' }}</div>

                            </div>
                        </div>

                        <div class="mb-3">
                            <h5>{{ __('messages.items') }}</h5>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.product') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.sale_price') }}</th>
                                        <th>{{ __('messages.subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->name ?? '-' }}
                                                @if($item->product && $item->product->stock_quantity <= 0)
                                                    <span class="badge bg-danger ms-2">{{ __('messages.out_of_stock') }}</span>
                                                @elseif($item->product && $item->quantity > $item->product->stock_quantity)
                                                    <span class="badge bg-warning ms-2">{{ __('messages.exceeds_stock') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->sale_price, 2) }}</td>
                                            <td>{{ number_format($item->quantity * $item->sale_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">{{ __('messages.total_amount') }}</th>
                                        <th>{{ number_format($sale->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm rounded-2">{{ __('messages.back') }}</a>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-primary btn-sm rounded-2">{{ __('messages.edit') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
