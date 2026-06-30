@extends('admin.layouts.app')

@section('page-title', 'Staff')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Staff Management</h3>

            @if(Auth::check() && in_array(Auth::user()->role, ['master_admin', 'admin']))
                <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Staff
                </a>
            @endif
        </div>

        <div class="card-body">

            @if($users->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($users as $user)

                                <tr>

                                    <td>{{ $user->id }}</td>

                                    <td>
                                        <img
                                            src="{{ asset('assets/images/customers/' . ($user->image ?? 'default.png')) }}"
                                            width="60"
                                            class="rounded"
                                            alt="{{ $user->name }}">
                                    </td>

                                    <td>{{ $user->name }}</td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.staff.edit', $user->id) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.staff.destroy', $user->id) }}"
                                              method="POST"
                                              style="display:inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this staff member?')">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info">
                    No results found.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection