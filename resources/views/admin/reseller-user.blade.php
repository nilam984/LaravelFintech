@extends('layouts.app')

@section('title', 'Reseller User')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Reseller User
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage all reseller users.
                </p>
            </div>

            <button type="button" id="btnAddUser" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                <i class="bi bi-plus-lg"></i>
                Reseller
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


    {{-- Add Modal --}}
    <div id="addUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-xl bg-white shadow-xl">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <h2 id="userModalTitle" class="text-lg font-semibold text-slate-800">
                        Add Reseller User
                    </h2>
                    <p class="text-sm text-slate-500">
                        Create a new Reseller User.
                    </p>
                </div>

                <button type="button" id="closeUserModal" class="text-slate-500 hover:text-red-500 text-xl">
                    &times;
                </button>
            </div>

            {{-- Form --}}
            <form id="addUserForm" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-5">

                    <div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">


                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Name
                                </label>

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


                        </div>
                    </div>


                    {{-- Aadhaar Details --}}
                    <div class="border-t pt-5">

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">


                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Aadhaar Number
                                </label>

                                <input type="text" name="aadhar_no" id="aadhar_no"
                                    placeholder="Enter 12 digit Aadhaar number" maxlength="12"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                                <span class="text-red-500 text-xs error-aadhar_no"></span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Aadhaar Front Image
                                </label>

                                <input type="file" name="aadhar_front_image" id="aadhar_front_image" accept="image/*"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                                <span class="text-red-500 text-xs error-aadhar_front_image"></span>
                            </div>


                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Aadhaar Back Image
                                </label>

                                <input type="file" name="aadhar_back_image" id="aadhar_back_image" accept="image/*"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                                <span class="text-red-500 text-xs error-aadhar_back_image"></span>
                            </div>

                        </div>
                    </div>


                    {{-- PAN Details --}}
                    <div class="border-t pt-5">

                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">


                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    PAN Number
                                </label>

                                <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN number"
                                    maxlength="10"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm uppercase focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                                <span class="text-red-500 text-xs error-pan_no"></span>
                            </div>


                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    PAN Image
                                </label>

                                <input type="file" name="pan_image" id="pan_image" accept="image/*"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                                <span class="text-red-500 text-xs error-pan_image"></span>
                            </div>

                        </div>
                    </div>

                </div>



                <div class="flex justify-end gap-3 border-t px-6 py-4 bg-slate-50 rounded-b-xl">

                    <button type="button" id="cancelUserModal"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg">
                        Cancel
                    </button>

                    <button type="submit" id="saveUserBtn"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg">
                        Save User
                    </button>

                </div>

            </form>
        </div>
    </div>


    {{-- Edit MOdal  --}}
    <div id="editUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-xl bg-white shadow-xl">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Edit Reseller User</h2>
                    <p class="text-sm text-slate-500">Update reseller user details.</p>
                </div>
                <button type="button" id="closeEditUserModal" class="text-slate-500 hover:text-red-500 text-xl">
                    &times;
                </button>
            </div>

            <form id="editUserForm" enctype="multipart/form-data">
                @csrf <input type="hidden" name="user_id" id="edit_user_id" />
                <div class="p-6 space-y-5">
                    <div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Name </label>
                                <input type="text" name="name" id="edit_user_name" placeholder="Enter name"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-edit-name"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Email </label>
                                <input type="email" name="email" id="edit_user_email" placeholder="Enter email"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-edit-email"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Mobile </label>
                                <input type="text" name="mobile" id="edit_user_mobile"
                                    placeholder="Enter mobile number" maxlength="10"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-edit-mobile"></span>
                            </div>
                        </div>
                    </div>
                    <div class="border-t pt-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Aadhaar Number </label>
                                <input type="text" name="aadhar_no" id="edit_aadhar_no"
                                    placeholder="Enter 12 digit Aadhaar number" maxlength="12"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-edit-aadhar_no"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Aadhaar Front Image </label>
                                <div class="flex items-center gap-3">
                                    <input type="file" name="aadhar_front_image" id="edit_aadhar_front_image"
                                        accept="image/*"
                                        class="flex-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                    {{-- Existing image preview --}}
                                    <button type="button" id="editAadharFrontPreview"
                                        class="hidden previewImage text-cyan-600 hover:text-cyan-800 text-lg"
                                        title="View Aadhaar Front">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <span class="text-slate-400 text-xs">
                                    Upload only if you want to replace the existing image.
                                </span>
                                <span class="block text-red-500 text-xs error-edit-aadhar_front_image"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Aadhaar Back Image </label>
                                <div class="flex items-center gap-3">
                                    <input type="file" name="aadhar_back_image" id="edit_aadhar_back_image"
                                        accept="image/*"
                                        class="flex-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                    {{-- Existing image preview --}}
                                    <button type="button" id="editAadharBackPreview"
                                        class="hidden previewImage text-cyan-600 hover:text-cyan-800 text-lg"
                                        title="View Aadhaar Back">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <span class="text-slate-400 text-xs">
                                    Upload only if you want to replace the existing image.
                                </span>
                                <span class="block text-red-500 text-xs error-edit-aadhar_back_image"></span>
                            </div>
                        </div>
                    </div>
                    <div class="border-t pt-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> PAN Number </label>
                                <input type="text" name="pan_no" id="edit_pan_no" placeholder="Enter PAN number"
                                    maxlength="10"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm uppercase focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-edit-pan_no"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> PAN Image </label>

                                <div class="flex items-center gap-3">
                                    <input type="file" name="pan_image" id="edit_pan_image" accept="image/*"
                                        class="flex-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />

                                    {{-- Existing image preview --}}
                                    <button type="button" id="editPanPreview"
                                        class="hidden previewImage text-cyan-600 hover:text-cyan-800 text-lg"
                                        title="View PAN Image">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>

                                <span class="text-slate-400 text-xs">
                                    Upload only if you want to replace the existing image.
                                </span>

                                <span class="block text-red-500 text-xs error-edit-pan_image"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t px-6 py-4 bg-slate-50 rounded-b-xl">
                    <button type="button" id="cancelEditUserModal"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" id="updateUserBtn"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg">
                        Update User
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
                    url: "{{ route('datatable', 'resellerUser') }}",
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
                                    class="editResellerBtn  bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg transition"
                                    data-id="${row.id}" >
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
                    "Reseller",
                    table
                );
            });


            $('#btnAddUser').click(function() {
                $('#addUserForm')[0].reset();
                $('#addUserModal').removeClass('hidden').addClass('flex');
            });


            $('#closeUserModal, #cancelUserModal').click(function() {
                $('#addUserModal').removeClass('flex').addClass('hidden');
            });
            $('#addUserModal, #editUserModal').click(function(e) {
                if (e.target === this) {
                    $(this).removeClass('flex').addClass('hidden');
                }
            });

            $('#addUserForm').submit(function(e) {
                e.preventDefault();

                let button = $('#saveUserBtn');

                button.prop('disabled', true);
                button.text('Saving...');

                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('admin.onboard.reseller') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#addUserModal').removeClass('flex').addClass('hidden');
                            $('#addUserForm')[0].reset();

                            ToastEngine.show(response.message, "success");
                            table.ajax.reload(null, false);
                        } else {
                            ToastEngine.show(response.message, "error");
                        }
                        button.prop('disabled', false);
                        button.text('Save User');
                    },
                    error: function(xhr) {

                        let message = xhr.responseJSON.message || "Something went wrong.";
                        ToastEngine.show(message, "error");
                        button.prop('disabled', false);
                        button.text('Save User');
                    }
                });
            });


            $(document).on("click", ".editResellerBtn", function() {
                let userId = $(this).data("id");
                const url = "{{ route('get.reseller', ['id' => ':id']) }}".replace(':id', userId)
                clearEditErrors();

                $("#edit_aadhar_front_image").val("");
                $("#edit_aadhar_back_image").val("");
                $("#edit_pan_image").val("");

                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function() {
                        $("#editUserModal").removeClass("hidden").addClass("flex");
                    },

                    success: function(response) {
                        if (!response.status) {
                            ToastEngine.show(response.message, "error");

                            return;
                        }

                        let data = response.data;

                        $("#edit_user_id").val(data.id);

                        $("#edit_user_name").val(data.name);

                        $("#edit_user_email").val(data.email);

                        $("#edit_user_mobile").val(data.mobile);

                        $("#edit_aadhar_no").val(data.aadhar_no);

                        if (data.aadhar_front_image) {
                            $('#editAadharFrontPreview')
                                .attr('data-src', data.aadhar_front_image)
                                .removeClass('hidden');
                        } else {
                            $('#editAadharFrontPreview')
                                .attr('data-src', '')
                                .addClass('hidden');
                        }

                        if (data.aadhar_back_image) {
                            $('#editAadharBackPreview')
                                .attr('data-src', data.aadhar_back_image)
                                .removeClass('hidden');
                        } else {
                            $('#editAadharBackPreview')
                                .attr('data-src', '')
                                .addClass('hidden');
                        }

                        $("#edit_pan_no").val(data.pan_no);

                        if (data.pan_image) {
                            $('#editPanPreview')
                                .attr('data-src', data.pan_image)
                                .removeClass('hidden');

                        } else {
                            $('#editPanPreview')
                                .attr('data-src', '')
                                .addClass('hidden');
                        }
                    },

                    error: function(xhr) {
                        let message = xhr.responseJSON?.message ||
                            "Unable to load reseller details.";
                        ToastEngine.show(message, "error");
                        $("#editUserModal").removeClass("flex").addClass("hidden");
                    },
                });
            });

            $("#editUserForm").submit(function(e) {
                e.preventDefault();

                let button = $("#updateUserBtn");

                button.prop("disabled", true);
                button.text("Updating...");

                let form = this;

                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('admin.reseller.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        if (response.status) {

                            $("#editUserModal").removeClass("flex").addClass("hidden");
                            $("#editUserForm")[0].reset();
                            ToastEngine.show(response.message, "success");
                            table.ajax.reload(null, false);

                        } else {
                            ToastEngine.show(response.message, "error");
                        }

                        button.prop("disabled", false);
                        button.text("Update User");
                    },

                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || "Something went wrong.";

                        ToastEngine.show(message, "error");

                        button.prop("disabled", false);
                        button.text("Update User");
                    },
                });
            });


            $('#closeEditUserModal, #cancelEditUserModal').on('click', function() {
                $('#editUserModal').removeClass('flex').addClass('hidden');
                $('#editUserForm')[0].reset();
                clearEditErrors();
            });


            function clearEditErrors() {

                $('.error-edit-name').text('');
                $('.error-edit-email').text('');
                $('.error-edit-mobile').text('');
                $('.error-edit-aadhar_no').text('');
                $('.error-edit-pan_no').text('');

                $('.error-edit-aadhar_front_image').text('');
                $('.error-edit-aadhar_back_image').text('');
                $('.error-edit-pan_image').text('');
            }

        });
    </script>
@endsection
@endsection
