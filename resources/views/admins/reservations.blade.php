@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Reservations</h2>
        <p class="text-gray-400 mt-1">Monitor, approve, and manage customer bookings.</p>
    </div>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Bookings</p>
            <h3 class="text-3xl font-bold mt-2">{{ $reservations->count() }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Cancelled</p>
            <h3 class="text-3xl font-bold mt-2 text-amber-500">
                {{ $reservations->where('status', 'cancelled')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Confirmed / Active</p>
            <h3 class="text-3xl font-bold mt-2 text-blue-600">
                {{ $reservations->where('status', 'confirmed')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Revenue</p>
            <h3 class="text-3xl font-bold mt-2 text-green-600">
                Rp {{ number_format($reservations->where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', '.') }}
            </h3>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50">
    <div class="flex justify-between items-center p-6 border-b">
        <h3 class="font-bold text-lg">All Reservations</h3>
        <input
            type="text"
            placeholder="Search code, customer name..."
            class="border rounded-xl px-4 py-2 text-sm w-72 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b bg-gray-50">
                <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                    <th class="px-6 py-4">Booking Code</th>
                    <th class="px-6 py-4">Guest</th>
                    <th class="px-6 py-4">Reservation Date</th>
                    <th class="px-6 py-4">Total Payment</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($reservations as $reservation)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-5">
                        <span class="font-bold text-blue-600 block">{{ $reservation->booking_code }}</span>
                        <span class="text-xs text-gray-400">Created {{ optional($reservation->created_at)->format('d M Y') }}</span>
                    </td>

                    <td class="px-6 py-5">
                        <span class="font-semibold text-gray-900 block">{{ $reservation->user->name ?? $reservation->guest_name }}</span>
                        <span class="text-xs text-gray-400 block">{{ $reservation->user->email ?? $reservation->guest_phone_number }}</span>
                    </td>

                    <td class="px-6 py-5 text-gray-600">
                        <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</div>
                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }} WIB</div>
                    </td>

                    <td class="px-6 py-5 font-semibold text-gray-900">
                        Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-5">
                        @if($reservation->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-xs font-bold capitalize">Pending</span>
                        @elseif($reservation->status == 'confirmed')
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold capitalize">Confirmed</span>
                        @elseif($reservation->status == 'completed')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold capitalize">Completed</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold capitalize">Cancelled</span>
                        @endif
                    </td>

                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2 items-center">
                            {{-- DETAIL BUTTON --}}
                            <button type="button"
                                   onclick="openDetailModal('{{ $reservation->id }}')"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition">
                                Detail
                            </button>

                            {{-- EDIT BUTTON --}}
                            <button type="button"
                                    onclick="openEditModal(this)"
                                    data-id="{{ $reservation->id }}"
                                    data-code="{{ $reservation->booking_code }}"
                                    data-status="{{ $reservation->status }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                Edit
                            </button>

                            {{-- DELETE/CANCEL FORM --}}
                            <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus reservasi {{ $reservation->booking_code }} ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-400">No reservations found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT CONTROL MODAL --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailModal = document.getElementById('detailModal');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editReservForm');

    // --- LOGIC DETAIL RESERVATION (AJAX Fetch) ---
    window.openDetailModal = function(id) {
        fetch(`/admin/reservations/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('det_code').innerText = data.booking_code;
                document.getElementById('det_guest').innerText = data.user ? data.user.name : data.guest_name;
                document.getElementById('det_contact').innerText = data.user ? data.user.email : data.guest_phone_number;
                document.getElementById('det_date').innerText = data.reservation_date;
                document.getElementById('det_time').innerText = data.reservation_time + ' WIB';
                document.getElementById('det_price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_price);
                document.getElementById('det_status').innerText = data.status.toUpperCase();

                detailModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
    }

    window.closeDetailModal = function() {
        detailModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // --- LOGIC EDIT STATUS ---
    window.openEditModal = function(button) {
        const id = button.getAttribute('data-id');
        const code = button.getAttribute('data-code');
        const status = button.getAttribute('data-status');

        document.getElementById('edit_title_code').innerText = code;
        document.getElementById('edit_status').value = status;
        
        editForm.action = `/admin/reservations/update/${id}`;

        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    window.closeEditModal = function() {
        editModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});
</script>
@endsection

@push('modals')
{{-- ================= MODAL DETAIL RESERVASI ================= --}}
<div id="detailModal" class="hidden fixed inset-0 w-screen h-screen z-[9999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-[28px] w-full max-w-md shadow-2xl overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-bold text-gray-900">Reservation Details</h3>
            <button type="button" onclick="closeDetailModal()" class="text-2xl text-gray-400 hover:text-gray-700">&times;</button>
        </div>
        <div class="p-6 space-y-4 text-sm">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Booking Code</span>
                <span id="det_code" class="font-bold text-blue-600"></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Guest Name</span>
                <span id="det_guest" class="font-semibold text-gray-900"></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Contact Info</span>
                <span id="det_contact" class="text-gray-700"></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Date</span>
                <span id="det_date" class="text-gray-700"></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Time</span>
                <span id="det_time" class="text-gray-700"></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-400">Total Price</span>
                <span id="det_price" class="font-bold text-gray-900"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Current Status</span>
                <span id="det_status" class="font-bold text-blue-600 uppercase"></span>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex justify-end border-t">
            <button type="button" onclick="closeDetailModal()" class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 font-semibold text-sm">Close</button>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT STATUS RESERVASI ================= --}}
<div id="editModal" class="hidden fixed inset-0 w-screen h-screen z-[9999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-[28px] w-full max-w-sm shadow-2xl overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Update Status</h3>
                <p class="text-xs text-gray-400 mt-1">Booking: <span id="edit_title_code" class="font-bold text-blue-600"></span></p>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-2xl text-gray-400 hover:text-gray-700">&times;</button>
        </div>
        <form id="editReservForm" action="" method="POST">
            @csrf
            <div class="p-6">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Select Status</label>
                <select id="edit_status" name="status" class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-2 border-t">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm font-medium">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm">Update</button>
            </div>
        </form>
    </div>
</div>
@endpush