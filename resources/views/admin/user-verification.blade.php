@extends('layouts.app')

@section('title', 'Verification User')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Verification User
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage all verification users.
                </p>
            </div>

            <button type="button" id="btnAddUser" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                <i class="bi bi-plus-lg"></i>
                Add User
            </button>

        </div>

        {{-- Filters --}}

        <div class="bg-white border border-slate-200 rounded-xl p-4">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <input type="text" id="search" placeholder="Search..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                </div>

                <div>
                    <select id="status"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button id="btnReset"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg transition">
                        Reset
                    </button>

                </div>

            </div>

        </div>


        {{-- DataTable --}}

        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="usersTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Update Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>



    <div id="addUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <h2 id="userModalTitle" class="text-lg font-semibold text-slate-800">
                        Add Verification User
                    </h2>
                    <p class="text-sm text-slate-500">
                        Create a new verification user.
                    </p>
                </div>

                <button type="button" id="closeUserModal" class="text-slate-500 hover:text-red-500 text-xl">
                    &times;
                </button>
            </div>

            {{-- Form --}}
            <form id="addUserForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                        <input type="text" name="name" id="user_name" placeholder="Enter name"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <span class="text-red-500 text-xs error-name"></span>
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Email
                        </label>

                        <input type="email" name="email" id="user_email" placeholder="Enter email"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <span class="text-red-500 text-xs error-email"></span>
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Mobile
                        </label>

                        <input type="text" name="mobile" id="user_mobile" placeholder="Enter mobile number"
                            maxlength="10"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <span class="text-red-500 text-xs error-mobile"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Password
                        </label>

                        <input type="password" name="password" id="user_password" placeholder="Enter password"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                        <span class="text-red-500 text-xs error-password"></span>
                    </div>

                </div>

                <div class="flex justify-end gap-3 border-t px-6 py-4">
                    <button type="button" id="cancelUserModal"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg">
                        Cancel
                    </button>

                    <button type="submit" id="saveUserBtn"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>

@section('scripts')
    <script>
        let table = null;

        $(function() {

            table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                scrollX: true,

                ajax: {
                    url: "{{ route('datatable', 'verificationUser') }}",
                    type: "POST",

                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('#status').val();
                    }
                },

                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'mobile',
                        name: 'mobile'
                    },

                    {
                        data: 'status',
                        name: 'status',

                        render: function(data) {
                            return data == 1 ?
                                '<span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Active</span>' :
                                '<span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Inactive</span>';
                        }
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',

                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },

                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',

                        render: function(data, type, row) {
                            return `
                            <select
                                class="user-status w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700"
                                data-id="${row.id}"
                                data-status="${data}">
                                <option value="1" ${data == 1 ? 'selected' : ''}>
                                    Active
                                </option>
                                <option value="0" ${data == 0 ? 'selected' : ''}>
                                    Inactive
                                </option>

                            </select>`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    type="button"
                                    class="editVerificationUser bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg transition"
                                    data-id="${row.id}"
                                    data-name="${row.name}"
                                    data-email="${row.email}"
                                    data-mobile="${row.mobile}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>`;
                        }
                    }
                ]
            });
            $('#search').keyup(function() {
                table.search(this.value).draw();
            });
            $('#status').change(function() {
                table.ajax.reload();
            });
            $('#btnReset').click(function() {
                $('#search').val('');
                $('#status').val('');
                table.search('').ajax.reload();
            });
            $(document).on('change', '.user-status', function() {
                changeStatus(
                    this,
                    "{{ route('users.change-status') }}",
                    "User",
                    table
                );
            });


            $('#btnAddUser').click(function() {
                $('#addUserForm')[0].reset();
                $('#user_id').val('');
                $('#userModalTitle').text('Add Verification User');
                $('#userModalDescription').text('Create a new verification user.');
                $('#saveUserBtn').text('Save User');
                $('.text-red-500').text('');
                $('#addUserModal').removeClass('hidden').addClass('flex');
            });

            $(document).on('click', '.editVerificationUser', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let mobile = $(this).data('mobile');
                $('#user_id').val(id);
                $('#user_name').val(name);
                $('#user_email').val(email);
                $('#user_mobile').val(mobile);
                $('#user_password').val('');
                $('#userModalTitle').text('Edit Verification User');
                $('#userModalDescription').text(
                    'Update verification user information.'
                );
                $('#saveUserBtn').text('Update User');
                $('.text-red-500').text('');
                $('#addUserModal')
                    .removeClass('hidden')
                    .addClass('flex');
            });


        
            $('#closeUserModal, #cancelUserModal').click(function() {
                $('#addUserModal').removeClass('flex').addClass('hidden');
            });
            $('#addUserModal').click(function(e) {
                if (e.target === this) {
                    $(this).removeClass('flex').addClass('hidden');
                }
            });
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                $('.text-red-500').text('');
                let button = $('#saveUserBtn');
                let id = $('#user_id').val();
                let url = id ? "{{ route('verification.user.update', ':id') }}".replace(':id', id) : "{{ route('verification.user.store') }}";
                button.prop('disabled', true);
                button.text(id ? 'Updating...' : 'Saving...');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#addUserModal').removeClass('flex').addClass('hidden');
                            $('#addUserForm')[0].reset();
                            $('#user_id').val('');
                            $('#userModalTitle').text('Add Verification User');
                            $('#userModalDescription').text(
                                'Create a new verification user.'
                            );
                            ToastEngine.show(
                                response.message,
                                "success"
                            );
                            table.ajax.reload(null, false);
                        } else {
                            ToastEngine.show(
                                response.message,
                                "error"
                            );
                        }
                    },

                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorText = "";
                            $.each(errors, function(key, value) {
                                errorText += value[0] + "<br>";
                            });
                            ToastEngine.show(
                                errorText,
                                "error"
                            );

                        } else {
                            ToastEngine.show(
                                xhr.responseJSON?.message ||
                                "Something went wrong.",
                                "error"
                            );
                        }
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        button.text(
                            $('#user_id').val() ?
                            'Update User' :
                            'Save User'
                        );
                    }
                });
            });
        });
    </script>
@endsection
@endsection
