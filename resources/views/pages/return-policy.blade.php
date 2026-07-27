@extends('layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'user-return-policy-page')
@section('page-class', 'user-return-policy-page')
@section('title', 'Return Policy')
@section('content')

<div class="container py-5">
    <h1 class="fw-bold mb-4">Return Policy</h1>
    <p class="text-muted">Last updated: July 2026</p>

    <h5 class="mt-4">1. Returns</h5>
    <p>You have 30 calendar days to return an item from the date you received it. To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.</p>

    <h5 class="mt-4">2. Refunds</h5>
    <p>Once we receive your item, we will inspect it and notify you that we have received your returned item. We will immediately notify you on the status of your refund after inspecting the item. If your return is approved, we will initiate a refund to your original method of payment.</p>

    <h5 class="mt-4">3. Shipping</h5>
    <p>You will be responsible for paying for your own shipping costs for returning your item. Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your refund.</p>

    <h5 class="mt-4">4. Contact</h5>
    <p>If you have any questions on how to return your item, <a href="{{ route('contact') }}">contact us</a>.</p>
</div>

@endsection
