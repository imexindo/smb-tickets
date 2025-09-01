@extends('layouts.main')

<title>Departments | SMB Claims</title>

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Departments</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('departements.store') }}" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Input Department name">
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> Create Department
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="dom-jqry" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Departments Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dprt as $department)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-cog"></i>
                                            {{ $department->name }}
                                        </span>
                                    </td>
                                    <td>{{ $department->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success text-white edit-department-btn py-2"
                                            data-id="{{ $department->id }}" data-name="{{ $department->name }}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger text-white delete-department py-2"
                                            data-id="{{ $department->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDepartmentForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="department_id">
                        <div class="form-group">
                            <label for="name">Department Name</label>
                            <input type="text" class="form-control" name="name" id="department_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveDepartment">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable();

            // Tampilkan data di modal saat tombol edit diklik
            $(document).on('click', '.edit-department-btn', function(e) {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#department_id').val(id);
                $('#department_name').val(name);
            });

            // Handle update permission
            $('#editDepartmentForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#department_id').val();
                let name = $('#permission_name').val();

                $.ajax({
                    url: `/admin/departements/update/${id}`,
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
                            text: 'Failed to update departements!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $(document).on('click', '.delete-department', function(e) {
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
                            url: `/admin/departements/destroy/${id}`,
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
                                    text: "Failed to delete department!",
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
