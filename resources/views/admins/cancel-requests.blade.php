@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Cancellation Requests</h2>
         
        </div>
        <div class="bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-100 flex items-center gap-2">
            <span class="text-blue-600 font-semibold text-sm">Total Requests:</span>
            <span class="bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-md">{{ $cancels->count() }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm text-sm" role="alert">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <div class="font-medium">{{ session('success') }}</div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        
        @if($cancels->isEmpty())
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                    <span class="material-symbols-outlined text-gray-400 text-3xl">disabled_by_default</span>
                </div>
                <h5 class="text-gray-900 font-semibold text-lg">No cancellation requests found</h5>
                <p class="text-gray-500 text-sm mt-1 max-w-xs mx-auto">All clear! There are no pending or historic cancellation requests to show right now.</p>
            </div>
        @else

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-12">#</th>
                            <th class="py-4 px-6">Reservation ID</th>
                            <th class="py-4 px-6">Flight Booking ID</th>
                            <th class="py-4 px-6">Reason</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Requested At</th>
                            <th class="py-4 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                        @foreach($cancels as $cancel)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 px-6 text-center font-medium text-gray-400 group-hover:text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            
                            <td class="py-4 px-6 font-mono text-xs font-semibold text-gray-900">
                                @if($cancel->reservation_id)
                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $cancel->reservation_id }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 font-mono text-xs font-semibold text-gray-900">
                                @if($cancel->flight_booking_id)
                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $cancel->flight_booking_id }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 max-w-xs truncate text-gray-600" title="{{ $cancel->reason }}">
                                {{ $cancel->reason }}
                            </td>

                            <td class="py-4 px-6">
                                @if($cancel->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($cancel->status == 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Approved
                                    </span>
                                @elseif($cancel->status == 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ ucfirst($cancel->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-xs text-gray-500">
                                {{ $cancel->created_at->format('d M Y, H:i') }}
                            </td>

                            <td class="py-4 px-6 text-right">
                                @if($cancel->status == 'pending')
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('admin.cancel.approve', $cancel->id) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" data-action="approve" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm shadow-emerald-100">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.cancel.reject', $cancel->id) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" data-action="reject" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-xl transition border border-rose-100">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2.5 py-1.5 rounded-xl border border-gray-100/80">
                                        Completed
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>
</div>

{{-- Script SweetAlert --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.action-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const button = form.querySelector('button[type="submit"]');
                const action = button.getAttribute('data-action'); 
                const confirmColor = action === 'approve' ? '#16a34a' : '#ef4444'; 
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Are you sure you want to ${action} this request?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: `Yes, ${action} it!`,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    });
</script>
@endsection