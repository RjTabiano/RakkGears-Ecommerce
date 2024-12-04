@extends('layout.admin_layout')


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Accounts</h6>
            <div class="dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Filter
    </button>
        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li><a class="dropdown-item small {{ $usertype == 'user' ? 'active' : '' }}" href="?usertype=user">User</a></li>
            <li><a class="dropdown-item small {{ $usertype == 'admin' ? 'active' : '' }}" href="?usertype=admin">Admin</a></li>
            <li><a class="dropdown-item small" href="{{ route('accounts') }}">Clear Filter</a></li>
        </ul>
        </div>
    </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-3">
                <thead>
                    <tr class="text-white">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Usertype</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->usertype }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if ($user->usertype == 'user')
                                <a class="btn btn-sm btn-success" href="{{ route('users.makeAdmin', $user->id) }}">Make Admin</a>
                            @elseif ($user->usertype == 'admin')
                                <a class="btn btn-sm btn-warning" href="{{ route('users.makeUser', $user->id) }}">Revert to User</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>


<div class="d-flex justify-content-end">
    {{ $users->appends(['usertype' => request()->query('usertype')])->links('pagination::bootstrap-4') }}
</div>
@endsection