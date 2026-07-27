@extends('layouts.app'){{-- Add your custom page ID and classes right here --}}
@section('page-id', 'user-faq-page')
@section('page-class', 'user-faq-page')
@section('title', 'FAQ' . ' - ' . config('app.name', 'StAutoparts'))
@section('content')
<div class="Faq-hero">    
<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">FAQs</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li style="color: var(--primary)">FAQs</li>
      </ul>
    </div>
  </div>
</section>  
</div>
<div class="Faqs-page-container py-5">
  <div class="container-fluid px-4">
    <div class="row justify-content-center Faqs-page-row">
      <div class="col-lg-8 Faqs-page-col" id="faqsAccordion">
        @forelse($faqs as $faq)
        <div class="card border-0 shadow-sm mb-3 Faqs-page-items">
          <div class="card-header bg-white collapsed" style="cursor:pointer" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}" aria-expanded="false">
            <h6 class="mb-0 d-flex justify-content-between align-items-center">
              {{ $faq->question }}
              <i class="fas fa-chevron-down"></i>
            </h6>
          </div>
          <div id="faq{{ $faq->id }}" class="card-body collapse" data-bs-parent="#faqsAccordion">
            <p class="mb-0">{{ $faq->answer }}</p>
          </div>
        </div>
        @empty
        <div class="bg-white rounded shadow-sm p-5 text-center">
          <i class="fas fa-info-circle text-muted mb-3" style="font-size:3rem"></i>
          <h3>No FAQs Available</h3>
          <p class="text-muted">Check back later for frequently asked questions.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<style>
[data-bs-toggle="collapse"] .fa-chevron-down { transition: transform 0.35s ease; }
[data-bs-toggle="collapse"].collapsed .fa-chevron-down { transform: rotate(0deg); }
[data-bs-toggle="collapse"]:not(.collapsed) .fa-chevron-down { transform: rotate(180deg); }
</style>
@endsection
