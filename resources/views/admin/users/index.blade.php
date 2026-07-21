@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    <div class="admin-topbar">
        <div>
            <h1 class="h3 mb-1">Users</h1>
            <p class="text-muted mb-0">Lahat ng naka-rehistrong account.</p>
        </div>
    </div>

    <div class="panel shadow-card p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Name</th>
                        <th>Email</th>
                        <th>Bookings</th>
                        <th>Joined</th>
                        <th>Role</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="ps-3">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->bookings_count }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $user->isAdmin() ? 'badge-role-admin' : 'badge-role-customer' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="pe-3">
                                <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                        <option value="customer" @selected($user->role === 'customer')>Customer</option>
                                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center py-5 text-muted">Wala pang naka-rehistrong user.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
