@extends('layouts.main')

<title>Group's | SMB Claims </title>

@include('includes.dt-css')

@section('content')
    <div class="pc-content">

        <div class="row">
            <div class="col-12 my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-plus-circle"></i>
                    Add Group
                </button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dom-jqry" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge {{ $item->colors }}">
                                                <i class="fa fa-check-circle"></i>
                                                {{ $item->name }}
                                            </span>
                                        </td>
                                        <td>
                                            
                                            @if (auth()->user()->hasRole('SUPERADMISTRATOR'))
                                                <button class="btn btn-sm btn-success text-white edit-group"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                            @endif
                                            {{-- <button class="btn btn-sm btn-danger text-white delete-group"
                                                data-id="{{ $item->id }}">
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

    {{-- Add --}}
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="role">Group Name</label>
                                <input type="text" class="form-control" name="name" id="Editname" placeholder="Name">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveGroup">Save</button>
                </div>
            </div>
        </div>
    </div>


    @include('includes.dt')

    <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable();

            $('.edit-group').on('click', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#Editname').val(name);
                $('#saveGroup').data('id', id);
            });

            $('#saveGroup').on('click', function() {
                let id = $(this).data('id');
                let name = $('#Editname').val();

                $.ajax({
                    url: `/admin/groups/update/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT',
                        name: name,
                    },
                    success: function(response) {
                        $('#exampleModalEdit').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => location.reload(), 400);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Failed to update group!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $('.delete-group').on('click', function() {
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
                            url: `/admin/groups/destroy/${id}`,
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
                                setTimeout(() => location.reload(), 400);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: 'Failed to delete group!',
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
