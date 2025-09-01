@extends('layouts.main')

<title>Roles | SMB Claims</title>


@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Roles</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('roles.store') }}" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Input Role name">
                                </div>
                            </div>
                            <div class="col-6 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> Create Role
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="dom-jqry" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-cog"></i>
                                            {{ $role->name }}
                                        </span>
                                    </td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success text-white edit-role-btn py-2"
                                            data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        {{-- <button class="btn btn-sm btn-danger text-white delete-role py-2"
                                            data-id="{{ $role->id }}">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="role">Role Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Role Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="permissions">Permissions</label>
                            <div id="permission-list">
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                            name="permissions[]" value="{{ $permission->id }}">
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveRole">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable();

            $(document).on('click', '.edit-role-btn', function(e) {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#name').val(name);
                $('#saveRole').data('id', id);

                $.ajax({
                    url: `/admin/roles/${id}/permissions`,
                    type: 'GET',
                    success: function(response) {
                        $('.permission-checkbox').prop('checked',
                            false); // Reset all checkboxes
                        response.permissions.forEach(function(permId) {
                            $('.permission-checkbox[value="' + permId + '"]').prop(
                                'checked', true);
                        });
                    }
                });
            });

            // Handle Save Edit Role
            $('#saveRole').on('click', function() {
                let id = $(this).data('id');
                let name = $('#name').val();
                let permissions = $('.permission-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: `/admin/roles/update/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT',
                        name: name,
                        permissions: permissions
                    },
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Failed to update role!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            // Handle delete role
            $(document).on('click', '.delete-role', function(e) {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/roles/destroy/${id}`, // Ubah ke route yang sesuai
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.success,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                setTimeout(() => location.reload(), 1000);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: 'Failed to delete role!',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
