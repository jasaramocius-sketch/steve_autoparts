@extends('user.layouts.dashboard')

@section('dashboard-content')

<h3>My Orders</h3>

<table class="table">
    <thead>
        <tr>
            <th>Order Number</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ currency_format($order->total_amount) }}</td>
            <td>{{ $order->status }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No orders found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection