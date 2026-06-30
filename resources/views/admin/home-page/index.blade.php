@extends('admin.layouts.app')

@section('page-title', 'Manage Home Page')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Home Page Sections</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Home Page Sections</h5>
                </div> -->
                <div class="card-body">
                    @if($sections->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Section Name</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sections as $section)
                                        <tr>
                                            <td>
                                                <strong>{{ ucfirst(str_replace('_', ' ', $section->section_name)) }}</strong>
                                            </td>
                                            <td>{{ Str::limit($section->title, 50) }}</td>
                                            <td>
                                                <span class="badge {{ $section->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{  $section->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $section->order }}</td>
                                            <td>
                                                <a href="{{ route('admin.home-page.edit', $section->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No sections found. Please run migrations to initialize home page sections.
                            <br><br>
                            <code>php artisan migrate</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
