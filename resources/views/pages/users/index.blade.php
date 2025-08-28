@extends('layouts.main')

<title>User's | SMB Claims</title>

@include('includes.dt-css')

<style>
    table {
        font-size: 15px;
    }
</style>
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dom-jqry" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Devisi</th>
                                    <th>Group</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                                    {{ $item->groupuser->division->name }}
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
                                            <button class="btn btn-sm btn-success btn-edit" data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}" data-email="{{ $item->email }}"
                                                data-roles="{{ $item->roles->pluck('id') }}"
                                                data-division="{{ $item->groupuser?->division_id ?? '' }}"
                                                data-group="{{ $item->groupuser?->group_id ?? '' }}">
                                                <i class="fa fa-pen"></i>
                                            </button>


                                            {{-- <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editUsers" tabindex="-1" aria-labelledby="editUsersLabel" aria-hidden="true">
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="roles">Role</label>
                                    <select class="form-control" name="roles[]" id="roles">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="division">Division</label>
                                    <select class="form-control" name="division" id="division">
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="group">Group</label>
                                    <select class="form-control" name="group" id="group">
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
                        <button type="button" class="btn btn-primary" id="saveUserChanges">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('includes.dt')

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
            let userId;
            // 
            $(".btn-edit").click(function() {
                userId = $(this).data("id");
                let name = $(this).data("name");
                let email = $(this).data("email");
                let roles = $(this).data("roles");
                let division = $(this).data("division");
                let group = $(this).data("group");

                roles = roles ? roles.toString().split(',') : [];

                $("#editUsers #name").val(name);
                $("#editUsers #email").val(email);
                $("#editUsers #roles").val(roles).trigger("change");
                $("#editUsers #division").val(division).trigger("change");
                $("#editUsers #group").val(group).trigger("change");

                $("#editUserForm").attr("action", "{{ route('users.update', ':id') }}".replace(':id',
                    userId));
                $("#editUsers").modal("show");
            });



            $("#saveUserChanges").click(function() {
                let name = $("#editUsers #name").val();
                let email = $("#editUsers #email").val();
                let roles = $("#editUsers #roles").val() || [];
                let division = $("#editUsers #division").val();
                let group = $("#editUsers #group").val();
                $.ajax({
                    url: "{{ route('users.update', ':id') }}".replace(':id', userId),
                    type: "PUT",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        name: name,
                        email: email,
                        roles: roles,
                        division: division,
                        group: group
                    },
                    success: function(response) {
                        $("#editUsers").modal("hide");

                        setTimeout(() => {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Successfully'
                                });

                                setTimeout(() => {
                                        location
                                            .reload();
                                    },
                                    300);
                            },
                            500);
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message || 'Error updating user'
                        });
                    }
                });
            });


            $(".btn-delete").click(function() {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/destroy/${id}`,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'User deleted successfully!',
                                    toast: true,
                                    position: 'top-end',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error deleting user!',
                                    text: xhr.responseJSON.message,
                                    toast: true,
                                    position: 'top-end',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
