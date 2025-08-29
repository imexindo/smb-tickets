@extends('layouts.main')

<title>User's | SMB Ticket's</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless align-middle" id="dom-jqry">
                        <thead class="table-light">
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
                                        <button class="btn btn-sm btn-success btn-edit" data-id="{{ $item->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}">
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

    {{-- edit --}}
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


        });
    </script>
@endsection
