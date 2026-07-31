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
                </div>
            </div>
            <div class="p-5">
                <div id="user-details" class="tab-content">
                    @include('user.user-details')
                </div>
            </div>
        </div>
    </div>

@endsection
