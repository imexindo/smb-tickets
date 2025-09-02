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
                    <table id="dom-jqry" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>No</th>
                                <th>Date</th>
                                <th>Request By</th>
                                <th>Role</th>
                                <th>Dep</th>
                                <th>Category</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('ticket.store') }}" method="post">
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
                                    <label for="upload_by_req">File Attachment <span
                                            style="font-weight: bold; color: rgb(159, 11, 11); font-style: italic">pdf,
                                            docx, png, jpg, jpeg, xlsx, csv, zip</span></label>
                                    <div id="drop-area"
                                        class="border border-2 border-dashed rounded p-4 text-center bg-light"
                                        style="cursor: pointer;">
                                        <p class="mb-2">Drag & Drop file di sini atau klik untuk pilih</p>
                                        <input type="file" id="fileElem" multiple
                                            accept=".pdf,.docx,.png,.jpg,.jpeg,.xlsx,.csv,.zip" hidden>
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('fileElem').click()">Pilih File</button>
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
            var table = $('#dom-jqry').DataTable();
        });
    </script>


    <script>
        const dropArea = document.getElementById("drop-area");
        const fileInput = document.getElementById("fileElem");
        const fileList = document.getElementById("file-list");

        const allowedExtensions = ['pdf', 'docx', 'png', 'jpg', 'jpeg', 'xlsx', 'csv', 'zip'];
        let uploadedFiles = [];

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => e.preventDefault(), false);
            dropArea.addEventListener(eventName, (e) => e.stopPropagation(), false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.classList.add('bg-primary-subtle');
            dropArea.addEventListener(eventName, () => dropArea.classList.add('bg-primary-subtle'));
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('bg-primary-subtle'));
        });

        dropArea.addEventListener('drop', (e) => {
            handleFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
            fileInput.value = "";
        });

        function handleFiles(files) {
            [...files].forEach(file => {
                const ext = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(ext)) {
                    alert(`File ${file.name} tidak diizinkan. Hanya pdf, docx, png, jpg, jpeg, csv, xlsx, zip.`);
                    return;
                }

                if (uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    alert(`File ${file.name} sudah diupload sebelumnya.`);
                    return;
                }

                uploadedFiles.push(file);

                const fileItem = document.createElement("div");
                fileItem.classList.add("border", "rounded", "p-2", "mb-2", "d-flex", "justify-content-between",
                    "align-items-center");
                fileItem.innerHTML = `
                <span>${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
                <button type="button" class="btn btn-sm btn-danger">Cancel</button>
            `;

                fileItem.querySelector("button").addEventListener("click", () => {
                    uploadedFiles = uploadedFiles.filter(f => !(f.name === file.name && f.size === file
                        .size));
                    fileItem.remove();
                });

                fileList.appendChild(fileItem);
            });
        }
    </script>
@endsection
