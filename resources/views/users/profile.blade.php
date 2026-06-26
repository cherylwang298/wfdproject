@extends('layouts.user')

@section('content')

@include('partials.navbar')

<div class="max-w-4xl mx-auto pt-24 pb-20 px-4 sm:px-6">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
            Profile Management
        </h1>
        <p class="text-sm text-gray-500 mt-1">Update your personal information and account security settings.</p>
    </div>

    {{-- ALERT NOTIFICATION --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-6 flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-8">
            
            {{-- PROFILE PICTURE SECTION --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100">
                <div class="relative group">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/'.$user->profile_picture) }}" 
                             class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover ring-4 ring-gray-50 shadow-inner">
                    @else
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-gray-100 to-gray-200 flex items-center justify-center text-4xl shadow-inner border border-gray-100">
                            👤
                        </div>
                    @endif
                </div>

                <div class="text-center sm:text-left space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">
                        Profile Avatar
                    </label>
                    <p class="text-xs text-gray-400 max-w-xs">Allowed JPG, JPEG or PNG. Max size of 2MB</p>
                    
                    {{-- Custom Styled Upload Button --}}
                    <div class="pt-1">
                        <label class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 cursor-pointer shadow-sm transition">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Choose New Photo
                            <input type="file" name="profile_picture" class="hidden" onchange="this.form.submit();">
                        </label>
                    </div>
                </div>

                {{-- Status Display Badge --}}
                <div class="sm:ml-auto self-center sm:self-start">
                    <span class="text-xs font-medium text-gray-400 block mb-1 text-center sm:text-right">Account Status</span>
                    @if(strtolower($user->status) == 'active')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 capitalize shadow-sm">
                            ● {{ $user->status }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 capitalize shadow-sm">
                            ● {{ $user->status }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- ACCOUNT INFORMATION --}}
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Username</label>
                        <input type="text" 
                               name="username" 
                               value="{{ old('username', $user->username) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm bg-gray-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Email Address</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm bg-gray-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">First Name</label>
                        <input type="text" 
                               name="first_name" 
                               value="{{ old('first_name', $user->first_name) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Name</label>
                        <input type="text" 
                               name="last_name" 
                               value="{{ old('last_name', $user->last_name) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone Number</label>
                        <input type="text" 
                               name="phone_number" 
                               value="{{ old('phone_number', $user->phone_number) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- SECURITY / PASSWORD MANAGEMENT --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Security Setting</h3>
                    <p class="text-xs text-gray-400 mt-1">Leave blank if you don't want to modify your current security credentials.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">New Password</label>
                        <input type="password" 
                               name="password" 
                               placeholder="••••••••"
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Confirm Password</label>
                        <input type="password" 
                               name="password_confirmation" 
                               placeholder="••••••••"
                               class="w-full border border-gray-200 rounded-xl p-3 mt-2 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    </div>
                </div>
            </div>

            {{-- FORM ACTIONS (SAVE & LOGOUT) --}}
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-between items-center gap-4">
                
                {{-- Logout Button Trigger --}}
                <button type="button"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="w-full sm:w-auto inline-flex items-center justify-center bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 font-semibold px-6 py-3.5 rounded-xl text-sm transition shadow-sm active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sign Out / Logout
                </button>

                {{-- Save Changes Button --}}
                <button type="submit" 
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3.5 rounded-xl text-sm transition shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:scale-[0.98]">
                    Save Changes
                </button>
            </div>

        </div>
    </form>

    {{-- HIDDEN LOGOUT FORM (Laravel Compliant) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

@endsection