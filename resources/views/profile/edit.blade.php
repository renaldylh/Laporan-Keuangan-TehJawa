@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">👤 Profil Pengguna</h1>
            <p class="text-teh-jawa-gray">Kelola informasi profil dan pengaturan keamanan akun Anda</p>
        </div>
        
        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-teh-jawa-gold">
                <h3 class="text-lg md:text-xl font-bold text-teh-jawa-black mb-6 flex items-center gap-3">
                    <svg class="icon-lg text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Informasi Profil</span>
                </h3>
                @include('profile.partials.update-profile-information-form')
            </div>
            
            <!-- Update Password -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-teh-jawa-green">
                <h3 class="text-lg md:text-xl font-bold text-teh-jawa-black mb-6 flex items-center gap-3">
                    <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    <span>Ubah Password</span>
                </h3>
                @include('profile.partials.update-password-form')
            </div>
            
            <!-- Delete Account -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-red-500">
                <h3 class="text-lg md:text-xl font-bold text-red-700 mb-6 flex items-center gap-3">
                    <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>Hapus Akun</span>
                </h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
