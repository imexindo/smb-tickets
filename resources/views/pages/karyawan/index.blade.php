@extends('layouts.main')

<title>Employees | SMB Ticket's</title>

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Employees</h5>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus-circle"></i>
                Add Employee
            </button>
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
                                <th>Roles</th>
                                <th>Department</th>
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
                                    <td>
                                        <span class="badge bg-warning">
                                            <i class="fa fa-building"></i>
                                            {{ $item->pt ? $item->pt->name : '-' }}
                                        </span>
                                    </td>
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
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fa fa-user-circle"></i>
                                            {{ $item->user ? $item->user->groupuser->department->name : '-' }}
                                        </span>
                                    </td>
                                    
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success text-white btn-edit py-2"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-pen"></i>
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


    <!-- Modal add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('karyawan.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik"
                                aria-describedby="emailHelpId" placeholder="Nomor Induk Karyawan" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="user_id">User</label>
                            <select class="form-control" name="user_id" id="user_id" required>
                                <option value="{{ null }}">Pilih user</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="pt_id">PT</label>
                            <select class="form-control" name="pt_id" id="pt_id" required>
                                <option value="{{ null }}">Pilih PT</option>
                                @foreach ($pt as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formKaryawan" method="post">
                @csrf
                <input type="hidden" name="id" id="karyawan_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalEditLabel">Edit Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik_edit" required readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="user_id">User</label>
                            <input type="text" class="form-control" name="user_id" id="user_id_edit" required
                                readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="pt_id">PT</label>
                            <select class="form-control" name="pt_id" id="pt_id_edit" required>
                                <option value="{{ null }}">Pilih PT</option>
                                <option value="">Pilih PT</option>
                                @foreach ($pt as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        $(document).ready(function() {

            var table = $('#dom-jqry').DataTable();

            // === EDIT ===
            $(document).on("click", ".btn-edit", function() {
                let id = $(this).data("id");

                $.get("{{ url('/admin/master/karyawan') }}/" + id + "/edit", function(res) {
                    $("#exampleModalEditLabel").text("Edit Employee");

                    $("#karyawan_id").val(res.karyawan.id);
                    $("#nik_edit").val(res.karyawan.nik);
                    $("#user_id_edit").val(res.karyawan.user ? res.karyawan.user.name : "");

                    let ptOptions = '<option value="{{ null }}">Pilih PT</option>';
                    $.each(res.pt, function(i, p) {
                        let selected = (p.id == res.karyawan.pt_id) ? "selected" : "";
                        ptOptions +=
                            `<option value="${p.id}" ${selected}>${p.name}</option>`;
                    });
                    $("#pt_id_edit").html(ptOptions);

                    $("#exampleModalEdit").modal("show");
                });
            });

            // === UPDATE ===
            // ketika berhasil reload modal edit
            $("#formKaryawan").submit(function(e) {
                e.preventDefault();
                let id = $("#karyawan_id").val();
                let formData = $(this).serialize() + "&_method=PUT";

                $.ajax({
                    url: "{{ url('/admin/master/karyawan/update') }}/" + id,
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        $("#exampleModalEdit").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.success,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message ||
                            "Terjadi kesalahan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msg,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });


        });
    </script>
@endsection
