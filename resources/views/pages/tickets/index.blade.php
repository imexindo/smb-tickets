@extends('layouts.main')

<title>Ticket | SMB Help Desk</title>
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Ticket</h5>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
                <i class="fa fa-plus-circle"></i>
                Add Ticket
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table id="dom-jqry" class="table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>No</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Request By</th>
                                <th>Role</th>
                                <th>Dep</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-pen"></i> Update
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa fa-check-circle"></i>
                                            {{ $item->latestHistory ? $item->latestHistory->status->name : '-' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 16px; font-weight: bold; color: rgb(25, 66, 200)">{{ $item->no }}</td>
                                    <td style="font-size: 14px; font-weight: bold; color: rgb(23, 23, 23)">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa fa-check-circle"></i>
                                            {{ $item->category ? $item->category->name : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-user"></i>
                                            {{ $item->user ? $item->user->name : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($item->user)
                                            @foreach ($item->user->roles as $role)
                                                <span class="badge bg-primary">
                                                    <i class="fa fa-user-cog"></i> {{ $role->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fa fa-building"></i>
                                            {{ $item->user ? $item->user->groupuser->department->name : '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="user_id">Request</label>
                                    <input type="text" class="form-control" name="user_id" id="user_id"
                                        value="{{ auth()->user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" name="date" id="date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="{{ null }}">Select category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->type == 0 ? 'APLIKASI' : 'SOFTWARE' }} - {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3 mb-1">
                                <div class="form-group">
                                    <label for="upload_by_req">File Attachment
                                        <span style="font-weight: bold; color: rgb(159, 11, 11); font-style: italic">
                                            pdf, docx, png, jpg, jpeg, xlsx, csv, zip
                                        </span>
                                    </label>
                                    <div id="drop-area"
                                        class="border border-2 border-dashed rounded p-4 text-center bg-light"
                                        style="cursor: pointer;">
                                        <p class="mb-2">Drag & Drop file di sini atau klik untuk pilih</p>
                                        <input type="file" id="fileElem" name="attachments[]" multiple hidden
                                            accept=".pdf,.docx,.png,.jpg,.jpeg,.xlsx,.csv,.zip">
                                    </div>
                                    <div id="file-list" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Desc</label>
                                    <textarea class="form-control" name="desc" id="desc" rows="5"></textarea>
                                </div>
                            </div>
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
    <div class="modal fade" id="modalAddEdit" tabindex="-1" aria-labelledby="modalAddEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTicket" method="post">
                @csrf
                <input type="hidden" name="id" id="karyawan_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddEditLabel">Edit Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik_edit" required readonly>
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
            $('#dom-jqry').DataTable({
                scrollX: true,
                columnDefs: [{
                        width: 50,
                        targets: 0
                    }, // #
                    {
                        width: 250,
                        targets: 1
                    }, // Action
                    {
                        width: 120,
                        targets: 2
                    }, // Status
                    {
                        width: 100,
                        targets: 3
                    }, // No
                    {
                        width: 120,
                        targets: 4
                    }, // Date
                    {
                        width: 150,
                        targets: 5
                    }, // Category
                    {
                        width: 150,
                        targets: 6
                    }, // Request By
                    {
                        width: 200,
                        targets: 7
                    }, // Role
                    {
                        width: 150,
                        targets: 8
                    }, // Dep
                    {
                        width: 150,
                        targets: 9
                    } // Created
                ],
                fixedColumns: true
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropArea = document.getElementById("drop-area");
            const fileInput = document.getElementById("fileElem");
            const fileList = document.getElementById("file-list");

            let selectedFiles = []; // simpan semua file

            // Hapus border highlight
            function removeHighlight() {
                dropArea.classList.remove("border-primary");
            }

            // Highlight area saat drag
            ["dragenter", "dragover"].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.classList.add("border-primary");
                });
            });

            // Hapus highlight saat drag keluar
            ["dragleave", "drop"].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    removeHighlight();
                });
            });

            // Klik area → buka file picker
            dropArea.addEventListener("click", () => fileInput.click());

            // Input file manual
            fileInput.addEventListener("change", (e) => {
                addFiles(e.target.files);
            });

            // Drop file ke area
            dropArea.addEventListener("drop", (e) => {
                let dt = e.dataTransfer;
                let files = dt.files;
                addFiles(files);
            });

            function addFiles(files) {
                for (let file of files) {
                    if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        selectedFiles.push(file);
                    }
                }
                updateFileList();
            }

            function updateFileList() {
                fileList.innerHTML = "";

                selectedFiles.forEach((file, index) => {
                    let item = document.createElement("div");
                    item.className =
                        "d-flex justify-content-between align-items-center border p-2 mb-2 rounded bg-white shadow-sm";

                    item.innerHTML = `
                    <span>${file.name} <small class="text-muted">(${(file.size / 20480).toFixed(1)} KB)</small></span>
                    <button type="button" class="btn btn-sm btn-danger ms-2" data-index="${index}">CANCEL</button>
                `;

                    fileList.appendChild(item);
                });

                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;

                fileList.querySelectorAll("button").forEach(btn => {
                    btn.addEventListener("click", () => {
                        const i = btn.getAttribute("data-index");
                        selectedFiles.splice(i, 1);
                        updateFileList();
                    });
                });
            }
        });
    </script>
@endsection
