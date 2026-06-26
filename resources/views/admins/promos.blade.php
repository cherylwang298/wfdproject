@extends('layouts.admin')

@section('content')

@php
    $promos = $promos ?? collect();
@endphp

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Promo Management</h2>
        <p class="text-gray-400 mt-1">Create and manage promotional discounts.</p>
    </div>

    <button
        type="button"
        onclick="openPromoModal()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold shadow transition">
        + Create Promo
    </button>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Promos</p>
            <h3 class="text-3xl font-bold mt-2">{{ $promos->count() }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Active</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->where('expired_at','>',now())->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Expired</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->where('expired_at','<',now())->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Quota</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->sum('quota') }}
            </h3>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50">
    <div class="flex justify-between items-center p-6 border-b">
        <h3 class="font-bold text-lg">All Promos</h3>
        <input
            type="text"
            placeholder="Search promo..."
            class="border rounded-xl px-4 py-2 text-sm w-72 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b bg-gray-50">
                <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                    <th class="px-6 py-4">Promo Code</th>
                    <th class="px-6 py-4">Discount</th>
                    <th class="px-6 py-4">Min Purchase</th>
                    <th class="px-6 py-4">Quota</th>
                    <th class="px-6 py-4">Expired</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($promos as $promo)
                @php
                    $expired = $promo->expired_at && \Carbon\Carbon::parse($promo->expired_at)->isPast();
                @endphp
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-5">
                        <span class="font-bold text-blue-600">{{ $promo->code }}</span>
                    </td>
                    <td class="px-6 py-5">
                        @if($promo->discount_type=='percentage')
                            {{ $promo->discount_value }}%
                        @else
                            Rp {{ number_format($promo->discount_value,0,',','.') }}
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        Rp {{ number_format($promo->min_purchase,0,',','.') }}
                    </td>
                    <td class="px-6 py-5">{{ $promo->quota }}</td>
                    <td class="px-6 py-5">
                        {{ optional($promo->expired_at)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-5">
                        @if($expired)
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">Expired</span>
                        @elseif($promo->quota <= 0)
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">Out of Quota</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2 items-center">
                            {{-- TOMBOL EDIT (Melempar data ke JS) --}}
                            <button type="button"
                                    onclick="openEditPromoModal(this)"
                                    data-id="{{ $promo->id }}"
                                    data-code="{{ $promo->code }}"
                                    data-type="{{ $promo->discount_type }}"
                                    data-value="{{ $promo->discount_value }}"
                                    data-min="{{ $promo->min_purchase }}"
                                    data-quota="{{ $promo->quota }}"
                                    data-expired="{{ $promo->expired_at ? \Carbon\Carbon::parse($promo->expired_at)->format('Y-m-d\TH:i') : '' }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                Edit
                            </button>

                
                            <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    onclick="return confirm('Delete promo {{ $promo->code }}?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-10 text-center text-gray-400">No promos found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal Elements
    const createModal = document.getElementById('createPromoModal');
    const createModalBox = document.getElementById('createModalBox');
    
    const editModal = document.getElementById('editPromoModal');
    const editModalBox = document.getElementById('editModalBox');
    const editForm = document.getElementById('editPromoForm');

    window.openPromoModal = function () {
        createModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    window.closePromoModal = function () {
        createModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    createModal.addEventListener('click', function (e) {
        if (!createModalBox.contains(e.target)) closePromoModal();
    });

    // --- EDIT MODAL LOGIC (Dinamis mengisi form) ---
    window.openEditPromoModal = function (button) {
        const id = button.getAttribute('data-id');
        const code = button.getAttribute('data-code');
        const type = button.getAttribute('data-type');
        const value = button.getAttribute('data-value');
        const min = button.getAttribute('data-min');
        const quota = button.getAttribute('data-quota');
        const expired = button.getAttribute('data-expired');

        // Set isi input form edit
        document.getElementById('edit_code').value = code;
        document.getElementById('edit_discount_type').value = type;
        document.getElementById('edit_discount_value').value = value;
        document.getElementById('edit_min_purchase').value = min;
        document.getElementById('edit_quota').value = quota;
        document.getElementById('edit_expired_at').value = expired;

        // Atur action form route secara dinamis menuju rute update Laravel
        editForm.action = `/admin/promos/update/${id}`;

        // Tampilkan modal edit
        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    window.closeEditPromoModal = function () {
        editModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    editModal.addEventListener('click', function (e) {
        if (!editModalBox.contains(e.target)) closeEditPromoModal();
    });
});
</script>
@endsection

@push('modals')

<div id="createPromoModal" class="hidden fixed inset-0 w-screen h-screen z-[9999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">   
    <div id="createModalBox" class="bg-white rounded-[28px] w-full max-w-xl shadow-2xl overflow-hidden transform transition-all">
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Create Promo</h3>
                <p class="text-sm text-gray-400 mt-1">Fill the promo information below.</p>
            </div>
            <button type="button" onclick="closePromoModal()" class="text-2xl text-gray-400 hover:text-gray-700">&times;</button>
        </div>

        <form action="{{ route('admin.promo.create') }}" method="POST">
            @csrf
            <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block mb-2 text-sm font-semibold">Promo Code</label>
                    <input type="text" name="code" required class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" placeholder="WELCOME10">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Discount Type</label>
                        <select name="discount_type" required class="w-full border rounded-xl px-4 py-3">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Discount Value</label>
                        <input type="number" name="discount_value" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Minimum Purchase</label>
                        <input type="number" name="min_purchase" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Quota</label>
                        <input type="number" name="quota" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Expired At</label>
                    <input type="datetime-local" name="expired_at" required class="w-full border rounded-xl px-4 py-3">
                </div>
            </div>
            <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50">
                <button type="button" onclick="closePromoModal()" class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">Save Promo</button>
            </div>
        </form>
    </div>
</div>


<div id="editPromoModal" class="hidden fixed inset-0 w-screen h-screen z-[9999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">   
    <div id="editModalBox" class="bg-white rounded-[28px] w-full max-w-xl shadow-2xl overflow-hidden transform transition-all">
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Edit Promo</h3>
                <p class="text-sm text-gray-400 mt-1">Change the promo information below.</p>
            </div>
            <button type="button" onclick="closeEditPromoModal()" class="text-2xl text-gray-400 hover:text-gray-700">&times;</button>
        </div>

        <form id="editPromoForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block mb-2 text-sm font-semibold">Promo Code</label>
                    <input type="text" id="edit_code" name="code" required class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Discount Type</label>
                        <select id="edit_discount_type" name="discount_type" required class="w-full border rounded-xl px-4 py-3">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Discount Value</label>
                        <input type="number" id="edit_discount_value" name="discount_value" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Minimum Purchase</label>
                        <input type="number" id="edit_min_purchase" name="min_purchase" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Quota</label>
                        <input type="number" id="edit_quota" name="quota" required class="w-full border rounded-xl px-4 py-3">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Expired At</label>
                    <input type="datetime-local" id="edit_expired_at" name="expired_at" required class="w-full border rounded-xl px-4 py-3">
                </div>
            </div>
            <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50">
                <button type="button" onclick="closeEditPromoModal()" class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white font-semibold">Update Promo</button>
            </div>
        </form>
    </div>
</div>
@endpush