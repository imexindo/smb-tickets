@extends('layouts.main')

<title>User's | SMB Ticket's</title>



@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Users</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-borderless align-middle" id="dom-jqry">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Group</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($users as $item)
                        <tr data-id="{{ $item->id }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->roles->isNotEmpty())
                                    @foreach ($item->roles as $role)
                                        <span class="badge bg-primary">
                                            <i class="fa fa-user-cog"></i>
                                            {{ $role->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        </span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($item->groupuser)
                                    <span class="badge bg-secondary">
                                        <i class="fa fa-user-circle"></i>
                                        {{ $item->groupuser->department->name }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>

                                @if ($item->groupuser)
                                    <span class="badge {{ $item->groupuser->group->colors }}">
                                        <i class="fa fa-check-circle"></i>
                                        {{ $item->groupuser->group->name }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->last_login)->format('d-m-Y H:i:s') }}
                            </td>

                            <td>
                                <button class="btn btn-sm btn-success btn-edit py-2" data-id="{{ $item->id }}">
                                    <i class="fa fa-pen"></i>
                                </button>

                                <button class="btn btn-sm btn-danger btn-delete py-2" data-id="{{ $item->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" tabindex="-1" aria-labelledby="editUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsersLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="roles">Role</label>
                                    <select class="form-control" name="roles[]" id="roles">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="dep_id">Department</label>
                                    <select class="form-control" name="dep_id" id="dep_id">
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="group">Group</label>
                                    <select class="form-control" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveUserChanges">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable({
                "scrollX": true,
                columnDefs: [{
                        targets: 0,
                        width: '40px'
                    },
                    {
                        targets: 1,
                        width: '100px',
                        className: 'text-center'
                    },
                    {
                        targets: 2,
                        width: '200px',
                        className: 'text-center'
                    },
                    {
                        targets: 3,
                        width: '150px',
                        className: 'text-left'
                    },
                    {
                        targets: 4,
                        width: '150px',
                        className: 'text-left'
                    },
                    {
                        targets: 5,
                        width: '150px',
                        className: 'text-left'
                    },
                    {
                        targets: 6,
                        width: '150px',
                        className: 'text-center'
                    },
                    {
                        targets: 7,
                        width: '100px',
                        className: 'text-center'
                    }
                ]
            });

            // === Button Edit ===
            $(document).on("click", ".btn-edit", function() {
                let id = $(this).data("id");

                $.ajax({
                    url: "/admin/users/" + id + "/edit",
                    type: "GET",
                    success: function(res) {
                        // isi input
                        $("#editUserForm #name").val(res.name);
                        $("#editUserForm #email").val(res.email);

                        // roles (multi select)
                        if (res.roles && res.roles.length > 0) {
                            let roleIds = res.roles.map(r => r.id);
                            $("#editUserForm #roles").val(roleIds).trigger("change");
                        } else {
                            $("#editUserForm #roles").val([]).trigger("change");
                        }

                        // group & department
                        if (res.groupuser) {
                            $("#editUserForm #dep_id")
                                .val(res.groupuser.dep_id)
                                .trigger("change");
                            $("#editUserForm #group")
                                .val(res.groupuser.group_id)
                                .trigger("change");
                        }

                        // set action form
                        $("#editUserForm").attr("action", "/admin/users/update/" + res.id);

                        // buka modal
                        $("#editUsersLabel").text("Edit User - " + res.name);
                        $("#editUsersLabel").closest(".modal").modal("show");
                    },
                    error: function() {
                        Swal.fire("Error", "Gagal mengambil data user!", "error");
                    },
                });
            });


            // // === Save Changes ===
            $(document).on("click", "#saveUserChanges", function() {
                let form = $("#editUserForm");
                let actionUrl = form.attr("action");
                let formData = form.serialize();

                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: formData + "&_method=PUT",
                    success: function(res) {
                        $("#editUsersLabel").closest(".modal").modal("hide");

                        Swal.fire("Success", res.success, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = "";
                            $.each(errors, function(key, value) {
                                errorMsg += value[0] + "<br>";
                            });
                            Swal.fire("Validation Error", errorMsg, "error");
                        } else {
                            Swal.fire("Error", "Terjadi kesalahan", "error");
                        }
                    },
                });
            });



            // Delete
            $(document).on("click", ".btn-delete", function() {
                let id = $(this).data("id");
                let csrf = $('meta[name="csrf-token"]').attr("content");

                Swal.fire({
                    title: "Yakin hapus user ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/users/destroy/" + id,
                            type: "POST",
                            data: {
                                _token: csrf,
                                _method: "DELETE",
                            },
                            success: function(res) {
                                Swal.fire("Deleted!", res.success ??
                                    "User berhasil dihapus.", "success").then(
                                    () => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire("Error", xhr.responseJSON?.message ??
                                    "Gagal menghapus user.", "error");
                            },
                        });
                    }
                });
            });





        });
    </script>
@endsection
