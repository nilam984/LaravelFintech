@extends('layouts.app')
@section('title', 'Admin Profile')
@section('content')
    <div class="min-h-screen bg-gray-100 py-6 px-5">
        <div class="flex items-center justify-between">
            <div class="mb-5">
                <h1 class="text-2xl font-bold text-fintechDarkText"> Profile </h1>
                <p class="text-sm text-fintechMutedText mt-1"> Manage Profile. </p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow">
            <div class="bg-white rounded-2xl  p-3 mb-6">
                <div class="flex flex-wrap gap-3">
                    <button class="profile-tab active flex items-center gap-2 px-5 py-3 rounded-xl transition-all duration-300 bg-cyan-600 text-white shadow-md"
                        data-tab="user-details">
                        <i class="bi bi-person-circle"></i>
                        <span>User Details</span>
                    </button>
                    <button class="profile-tab flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-cyan-50 hover:text-cyan-600 transition-all duration-300"
                        data-tab="business-details">
                        <i class="bi bi-building"></i>
                        <span>Business Details</span>
                    </button>
                    <button class="profile-tab flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-cyan-50 hover:text-cyan-600 transition-all duration-300"
                        data-tab="bank-details">
                        <i class="bi bi-bank"></i>
                        <span>Bank Details</span>
                    </button>
                    
                </div>

            </div>
            <div class="p-5">
                <div id="user-details" class="tab-content">
                    @include('user.user-details')
                </div>
                <div id="business-details" class="tab-content hidden">
                    @include('user.business-details')
                </div>
                <div id="bank-details" class="tab-content hidden">
                    @include('user.bank-details')
                </div>
               
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.profile-tab').click(function() {
                $('.profile-tab')
                    .removeClass('bg-cyan-600 text-white shadow-md')
                    .addClass('bg-gray-100 text-gray-700');
                $(this)
                    .removeClass('bg-gray-100 text-gray-700')
                    .addClass('bg-cyan-600 text-white shadow-md');
                $('.tab-content').addClass('hidden');
                $('#' + $(this).data('tab')).removeClass('hidden');
            });
        });
    </script>
    
   
@endsection
@endsection
