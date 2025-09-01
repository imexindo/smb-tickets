@extends('layouts.main')

<title>Karyawan | SMB Ticket's</title>

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Karyawan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table id="dom-jqry" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>PT</th>
                                <th>Department</th>
                                <th>Roles</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-user-circle"></i>
                                            {{ $item->user ? $item->user->name : '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->pt ? $item->pt->name : '-' }}</td>
                                    <td>{{ $item->user ? $item->user->groupuser->department->name : '-' }}</td>
                                    <td>
                                        @if ($item->user)
                                            @foreach ($item->user->roles as $role)
                                                <span class="badge bg-success">
                                                    <i class="fa fa-user-cog"></i>
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success text-white btn py-2"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger text-white py-2"
                                            data-id="{{ $item->id }}">
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
                let formData = new FormData(this);

                $.ajax({
                    url: `/admin/departements/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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
