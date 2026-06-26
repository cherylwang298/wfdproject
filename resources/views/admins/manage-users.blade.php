@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">User Management</h2>
        <p class="text-gray-400 mt-1">Manage system users, roles, and account statuses.</p>
    </div>

    {{-- {{ route('admin.users.create') }} --}}
    <a href=""
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold shadow">
        + Add New User
    </a>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Users</p>
            <h3 class="text-3xl font-bold mt-2">{{ $users->count() }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Administrators</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $users->where('role', 'admin')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Regular Users</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $users->where('role', 'user')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Active Today</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $users->where('last_login_at', '>', now()->startOfDay())->count() }}
            </h3>
        </div>
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50">

    <div class="flex justify-between items-center p-6 border-b">
        <h3 class="font-bold text-lg">
            All Users
        </h3>

        <input
            type="text"
            placeholder="Search user by name or email..."
            class="border rounded-xl px-4 py-2 text-sm w-72 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b bg-gray-50">
                <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                    <th class="px-6 py-4">User Details</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Joined Date</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    
                    {{-- Nama & Avatar/Inisial --}}
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm uppercase">
                                {{ substr($user->first_name, 0, 2) }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">
                                    {{$user->first_name}} {{ $user->last_name }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    ID: #{{ $user->id }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-5 text-gray-600">
                        {{ $user->email }}
                    </td>



                    <td class="px-6 py-5 text-gray-500">
                        {{ optional($user->created_at)->format('d M Y') }}
                    </td>

                    {{-- Status Terverifikasi/Aktif --}}
                    <td class="px-6 py-5">
                        @if($user->status == 'active')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">
                                Suspended
                            </span>
                        @endif
                    </td>

                    {{-- status->active/suspended or apa gitu nanti --}}

                    {{-- Actions --}}
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            {{-- {{ route('admin.users.edit', $user) }} --}}
                            
                            <button
    type="button"
    onclick="openUserModal(this)"
    data-id="{{ $user->id }}"
    data-name="{{ $user->first_name }} {{ $user->last_name }}"
    data-email="{{ $user->email }}"
    data-role="{{ $user->role }}"
    data-status="{{ $user->status }}"
    data-created="{{ optional($user->created_at)->format('d M Y') }}"
    class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
    Details
</button>

                            <button
    type="button"
    onclick="openStatusModal(this)"
    data-id="{{ $user->id }}"
    data-status="{{ $user->status }}"
    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-xl text-sm">
    Edit
</button>



                            {{-- {{ route('admin.users.destroy', $user) }} --}}
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-400">
                        No users found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function openUserModal(el) {
    document.getElementById('userModal').classList.remove('hidden');

    document.getElementById('modal-name').innerText = el.dataset.name;
    document.getElementById('modal-email').innerText = el.dataset.email;
    // document.getElementById('modal-role').innerText = el.dataset.role;
    document.getElementById('modal-status').innerText = el.dataset.status;
    document.getElementById('modal-created').innerText = el.dataset.created;

    const statusEl = document.getElementById('modal-status');
    statusEl.innerText = el.dataset.status;

    if (el.dataset.status === 'active') {
        statusEl.className = "font-semibold text-green-600";
    } else {
        statusEl.className = "font-semibold text-orange-600";
    }

    document.getElementById('modal-created').innerText = el.dataset.created;
}

function openStatusModal(el) {
    document.getElementById('statusModal').classList.remove('hidden');

    const id = el.dataset.id;
    const status = el.dataset.status;

    document.getElementById('status-user-id').value = id;
    document.getElementById('status-select').value = status;

    document.getElementById('statusForm').action = `/admin/users/update/${id}`;
}
function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
</script>

@endsection

@push('modals')

{{-- USER DETAIL MODAL --}}
<div id="userModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-900">User Details</h2>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        {{-- CONTENT --}}
        <div class="p-6 space-y-3 text-sm">

            <div>
                <p class="text-gray-400">Name</p>
                <p id="modal-name" class="font-bold text-gray-900"></p>
            </div>

            <div>
                <p class="text-gray-400">Email</p>
                <p id="modal-email" class="text-gray-700"></p>
            </div>


            <div>
                <p class="text-gray-400">Status</p>
                <p id="modal-status" class="font-semibold"></p>
            </div>

            <div>
                <p class="text-gray-400">Joined</p>
                <p id="modal-created" class="text-gray-700"></p>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="bg-gray-50 px-6 py-4 flex justify-end">
            <button onclick="closeUserModal()" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
                Close
            </button>
        </div>

    </div>
</div>


<div id="statusModal" class="hidden fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl">

        <div class="flex justify-between p-4 border-b">
            <h2 class="font-bold">Edit User Status</h2>
            <button onclick="closeStatusModal()">&times;</button>
        </div>

        <form id="statusForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="status-user-id" name="user_id">

            <div>
                <label class="text-sm text-gray-500">Status</label>
                <select id="status-select" name="status"
                    class="w-full border rounded-xl px-3 py-2 mt-1">
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button"
                    onclick="closeStatusModal()"
                    class="px-4 py-2 bg-gray-200 rounded-xl text-sm">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm">
                    Save
                </button>
            </div>

        </form>

    </div>
</div>
@endpush

