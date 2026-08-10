@extends('layouts.app')
@section('title', 'Menu Management')
@section('content')

    <div class="p-4 md:p-5 space-y-4">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Menu Management
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage menu and submenu visibility for each panel.
                </p>
            </div>

            <button type="submit" form="menuPermissionsForm"
                class="inline-flex items-center gap-2
                   bg-fintechCyan hover:bg-fintechCyanHover
                   text-white px-4 py-2 rounded-lg
                   transition">
                <i class="bi bi-check2-circle"></i>
                Save Changes
            </button>
        </div>


        {{-- ========================================================= --}}
        {{-- PERMISSION LEGEND --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200 rounded-xl p-4">

            <div class="flex items-center justify-between mb-3">

                <div>
                    <h2 class="font-semibold text-fintechDarkText">
                        Visibility
                    </h2>
                    <p class="text-xs text-fintechMutedText mt-0.5">
                        Select which panel can access each menu.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">

                {{-- Everyone --}}

                <div class="border border-slate-200 bg-green-100 rounded-lg px-3 py-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-slate-700">
                            Everyone
                        </span>
                    </div>

                    <p class="text-[11px] text-slate-400 mt-0.5">
                        All panels
                    </p>

                </div>

                {{-- Roles --}}

                @foreach ($roles as $role => $label)
                    @php
                        $roleColor = match ($role) {
                            'admin' => 'bg-red-100',
                            'user' => 'bg-blue-100',
                            'reseller' => 'bg-purple-100',
                            'verification' => 'bg-yellow-100',
                            default => 'bg-slate-100',
                        };
                    @endphp

                    <div class="border border-slate-200 rounded-lg  {{$roleColor}}  px-3 py-2">

                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-slate-700">
                                {{ $label }}
                            </span>
                        </div>

                        <p class="text-[11px] text-slate-400 mt-0.5">
                            {{ ucfirst($role) }} panel
                        </p>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- MENU PERMISSION TABLE --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

            <form id="menuPermissionsForm" action="{{ route('admin.menus.update') }}" method="POST">

                @csrf
                @method('PUT')
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th
                                    class="text-left px-4 py-3
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    Menu / Submenu
                                </th>

                                <th
                                    class="px-2 py-3 text-center
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    Everyone
                                </th>

                                <th
                                    class="px-2 py-3 text-center
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    Admin
                                </th>

                                <th
                                    class="px-2 py-3 text-center
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    User
                                </th>

                                <th
                                    class="px-2 py-3 text-center
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    Reseller
                                </th>

                                <th
                                    class="px-2 py-3 text-center
                                       text-xs font-semibold
                                       text-slate-500 uppercase
                                       tracking-wider">
                                    Verification
                                </th>
                            </tr>
                        </thead>


                        {{-- ================================================= --}}
                        {{-- TABLE BODY --}}
                        {{-- ================================================= --}}

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($menus as $menu)
                                @php
                                    $visibleFor = $menu->visible_for
                                        ? array_filter(explode(',', $menu->visible_for))
                                        : [];

                                    $isDefault = in_array('default', $visibleFor);
                                @endphp


                                {{-- ================================================= --}}
                                {{-- PARENT MENU --}}
                                {{-- ================================================= --}}

                                <tr class="bg-slate-50/70 hover:bg-slate-100 transition">

                                    <td class="px-4 py-3">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="w-8 h-8 rounded-lg
                                                   bg-fintechCyan/10
                                                   flex items-center
                                                   justify-center
                                                   flex-shrink-0">
                                                <i
                                                    class="bi {{ $menu->icon ?? 'bi-list' }}
                                                       text-fintechCyan">
                                                </i>
                                            </div>

                                            <div class="leading-tight">

                                                <div class="flex items-center gap-2">

                                                    <span class="font-semibold text-fintechDarkText">
                                                        {{ $menu->name }}

                                                    </span>

                                                    <span
                                                        class="px-1.5 py-0.5 rounded
                                                           bg-fintechCyan/10
                                                           text-fintechCyan
                                                           text-[9px]
                                                           font-medium uppercase">

                                                        Parent

                                                    </span>

                                                </div>

                                                <p class="text-[11px] text-fintechMutedText mt-0.5">
                                                    {{ $menu->slug }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Everyone --}}

                                    <td class="text-center px-2">

                                        <input type="checkbox" name="menus[{{ $menu->id }}][visible_for][]"
                                            value="default"
                                            class="menu-default-checkbox
                                               w-4 h-4
                                               rounded
                                               border-slate-300
                                               text-fintechCyan
                                               focus:ring-fintechCyan"
                                            data-menu-id="{{ $menu->id }}" {{ $isDefault ? 'checked' : '' }}>

                                    </td>


                                    {{-- Roles --}}

                                    @foreach ($roles as $role => $label)
                                        <td class="text-center px-2">

                                            <input type="checkbox" name="menus[{{ $menu->id }}][visible_for][]"
                                                value="{{ $role }}"
                                                class="menu-role-checkbox
                                                   w-4 h-4
                                                   rounded
                                                   border-slate-300
                                                   text-fintechCyan
                                                   focus:ring-fintechCyan"
                                                data-menu-id="{{ $menu->id }}"
                                                {{ in_array($role, $visibleFor) ? 'checked' : '' }}>

                                        </td>
                                    @endforeach

                                </tr>


                                {{-- ================================================= --}}
                                {{-- CHILD MENUS --}}
                                {{-- ================================================= --}}

                                @foreach ($menu->children as $child)
                                    @php
                                        $childVisibleFor = $child->visible_for
                                            ? array_filter(explode(',', $child->visible_for))
                                            : [];

                                        $childIsDefault = in_array('default', $childVisibleFor);
                                    @endphp


                                    <tr class="hover:bg-slate-50 transition">

                                        <td class="px-4 py-2.5">

                                            <div class="flex items-center">

                                                {{-- Tree connector --}}

                                                <div
                                                    class="ml-4 mr-3
                                                       w-6 h-4
                                                       border-l
                                                       border-b
                                                       border-slate-300
                                                       flex-shrink-0">
                                                </div>


                                                <div class="leading-tight">

                                                    <div class="flex items-center gap-2">

                                                        <span class="text-sm text-slate-700">

                                                            {{ $child->name }}

                                                        </span>

                                                        <span
                                                            class="px-1.5 py-0.5
                                                               rounded
                                                               bg-slate-100
                                                               text-slate-400
                                                               text-[9px]
                                                               font-medium">

                                                            Submenu

                                                        </span>

                                                    </div>


                                                    @if ($child->route)
                                                        <p
                                                            class="text-[11px]
                                                               text-slate-400
                                                               mt-0.5">

                                                            {{ $child->route }}

                                                        </p>
                                                    @endif

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Everyone --}}

                                        <td class="text-center px-2">

                                            <input type="checkbox" name="menus[{{ $child->id }}][visible_for][]"
                                                value="default"
                                                class="menu-default-checkbox
                                                   w-4 h-4
                                                   rounded
                                                   border-slate-300
                                                   text-fintechCyan
                                                   focus:ring-fintechCyan"
                                                data-menu-id="{{ $child->id }}" {{ $childIsDefault ? 'checked' : '' }}>

                                        </td>


                                        {{-- Roles --}}

                                        @foreach ($roles as $role => $label)
                                            <td class="text-center px-2">

                                                <input type="checkbox" name="menus[{{ $child->id }}][visible_for][]"
                                                    value="{{ $role }}"
                                                    class="menu-role-checkbox
                                                       w-4 h-4
                                                       rounded
                                                       border-slate-300
                                                       text-fintechCyan
                                                       focus:ring-fintechCyan"
                                                    data-menu-id="{{ $child->id }}"
                                                    {{ in_array($role, $childVisibleFor) ? 'checked' : '' }}>

                                            </td>
                                        @endforeach

                                    </tr>
                                @endforeach
                            @endforeach


                            {{-- ================================================= --}}
                            {{-- EMPTY STATE --}}
                            {{-- ================================================= --}}

                            @if ($menus->isEmpty())
                                <tr>

                                    <td colspan="6" class="px-4 py-10 text-center">

                                        <div class="flex flex-col items-center">

                                            <div
                                                class="w-10 h-10 rounded-full
                                                   bg-slate-100
                                                   flex items-center
                                                   justify-center
                                                   mb-2">

                                                <i
                                                    class="bi bi-menu-button-wide
                                                       text-slate-400">
                                                </i>

                                            </div>

                                            <p class="text-sm font-medium text-slate-600">
                                                No menus found.
                                            </p>

                                            <p class="text-xs text-slate-400 mt-0.5">
                                                Please run the MenuSeeder.
                                            </p>

                                        </div>

                                    </td>

                                </tr>
                            @endif

                        </tbody>

                    </table>

                </div>

            </form>

        </div>

    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document
                .querySelectorAll('.menu-default-checkbox')
                .forEach(function(defaultCheckbox) {

                    const menuId = defaultCheckbox.dataset.menuId;

                    const roleCheckboxes = document.querySelectorAll(
                        `.menu-role-checkbox[data-menu-id="${menuId}"]`
                    );


                    function applyDefaultState() {
                        if (defaultCheckbox.checked) {
                            roleCheckboxes.forEach(function(checkbox) {
                                checkbox.checked = true;
                                checkbox.disabled = true;
                            });
                        } else {
                            roleCheckboxes.forEach(function(checkbox) {
                                checkbox.disabled = false;
                            });
                        }
                    }

                    defaultCheckbox.addEventListener('change', function() {
                        applyDefaultState();
                    });
                    applyDefaultState();

                });

        });
    </script>
@endsection

@endsection
