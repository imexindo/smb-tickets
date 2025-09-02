@extends('layouts.main')

<title>Permission's | SMB Help Desk</title>


@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Permissions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Input Permission name">
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> Create Permission
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="dom-jqry" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permissions Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-cog"></i>
                                            {{ $permission->name }}
                                        </span>
                                    </td>
                                    <td>{{ $permission->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success text-white edit-permission-btn py-2"
                                            data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger text-white delete-permission py-2"
                                            data-id="{{ $permission->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPermissionForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="permission_id">
                        <div class="form-group">
                            <label for="name">Permission Name</label>
                            <input type="text" class="form-control" name="name" id="permission_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="savePermission">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable();

            // Tampilkan data di modal saat tombol edit diklik
            $(document).on('click', '.edit-permission-btn', function(e) {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#permission_id').val(id);
                $('#permission_name').val(name);
            });

            // Handle update permission
            $('#editPermissionForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#permission_id').val();
                let name = $('#permission_name').val();

                $.ajax({
                    url: `/admin/permissions/update/${id}`,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name
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
                            text: 'Failed to update permission!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $(document).on('click', '.delete-permission', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/permissions/destroy/${id}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: response.success,
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                setTimeout(() => location.reload(), 1000);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops!",
                                    text: "Failed to delete permission!",
                                    toast: true,
                                    position: "top-end",
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
