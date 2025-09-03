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
                                <th>Departement</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalView" data-id="{{ Crypt::encrypt($item->id) }}">
                                            <i class="fa fa-eye"></i> View
                                        </button>

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalUpdate" data-id="{{ Crypt::encrypt($item->id) }}">
                                            <i class="fa fa-edit"></i> Process
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->latestHistory->status->bg_color }}">
                                            <i class="fa fa-check-circle"></i>
                                            {{ $item->latestHistory ? $item->latestHistory->status->name : '-' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 16px; font-weight: bold; color: rgb(25, 66, 200)">
                                        {{ $item->no }}</td>
                                    <td style="font-size: 14px; font-weight: bold; color: rgb(23, 23, 23)">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa fa-newspaper"></i>
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
                                    <td style="color: black">{{ $item->created_at }}</td>
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
                                    <div id="drop-area" class="border border-2 border-dashed rounded p-5 text-center"
                                        style="cursor: pointer;">
                                        <p class="mb-2">Drag & Drop file di sini atau klik untuk pilih</p>
                                        <input type="file" id="fileElem" name="attachments[]" multiple hidden
                                            accept=".pdf,.docx,.png,.jpg,.jpeg,.xlsx,.csv,.zip,.rar">
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

    <!-- Modal Process-->
    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateLabel">Process</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">No</label>
                                <input type="text" class="form-control" aria-describedby="helpId" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Request</label>
                                <input type="text" class="form-control" aria-describedby="helpId" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="text" class="form-control" aria-describedby="helpId" readonly>
                            </div>
                        </div>
                        <div class="col-8 mt-2">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" name="category_id" id="category_id"
                                    id="category_id_history">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->type == 0 ? 'APLIKASI' : 'SOFTWARE' }} - {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4 mt-2">
                            <div class="form-group">
                                <label for="">Departement</label>
                                <input type="text" class="form-control" aria-describedby="helpId" readonly>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label for="desc">Descriptions</label>
                                <textarea class="form-control" name="desc" id="desc_history" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-8 mt-2">
                            <div class="form-group">
                                <label for="status_edit_history">Next Action</label>
                                <select class="form-control" name="status_id" id="status_edit_history">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4 mt-2">
                            <div class="form-group">
                                <label for="date_history">Process Date</label>
                                <input type="date" class="form-control" name="date" id="date_history"
                                    aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 mt-3 mb-1">
                                <div class="form-group">
                                    <label for="upload_by_req">File Attachment IT
                                        <span style="font-weight: bold; color: rgb(159, 11, 11); font-style: italic;">
                                            pdf, docx, png, jpg, jpeg, xlsx, csv, zip
                                        </span>
                                    </label>
                                    <div id="drop-area" class="border border-2 border-dashed rounded p-5 text-center"
                                        style="cursor: pointer;">
                                        <p class="mb-2">Drag & Drop file di sini atau klik untuk pilih</p>
                                        <input type="file" id="fileElem" name="attachments[]" multiple hidden
                                            accept=".pdf,.docx,.png,.jpg,.jpeg,.xlsx,.csv,.zip,.rar">
                                    </div>
                                    <div id="file-list" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label for="remark_history">Remark</label>
                                <textarea class="form-control" name="remark" id="remark_history" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-save"></i>&nbsp;Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View-->
    <div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalViewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalViewLabel">View</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive-lg">
                                <table class="table">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th scope="col" class="text-white">No</th>
                                            <th scope="col" class="text-white">Date</th>
                                            <th scope="col" class="text-white">Category</th>
                                            <th scope="col" class="text-white">Attachment User</th>
                                            <th scope="col" class="text-white">Attachment IT</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                <table class="table table-striped table-inverse table-responsive">
                                    <thead class="thead-inverse">
                                        <tr class="bg-secondary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Status</th>
                                            <th class="text-white">Remark</th>
                                            <th class="text-white">Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // table
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

            function formatDateTime(datetime) {
                if (!datetime) return '-';
                let d = new Date(datetime);
                if (isNaN(d.getTime())) return datetime;
                let day = String(d.getDate()).padStart(2, '0');
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let year = d.getFullYear();
                let hours = String(d.getHours()).padStart(2, '0');
                let mins = String(d.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${mins}`;
            }

            function formatDate(datetime) {
                if (!datetime) return '-';
                let d = new Date(datetime);
                if (isNaN(d.getTime())) return datetime;
                let day = String(d.getDate()).padStart(2, '0');
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let year = d.getFullYear();
                let hours = String(d.getHours()).padStart(2, '0');
                let mins = String(d.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year}`;
            }

            // View
            $(document).on("click", ".btn[data-bs-target='#modalView']", function() {
                let id = $(this).data("id"); // ambil data-id dari tombol
                let url = "{{ route('ticket.get-data', ':id') }}".replace(':id', id);

                // kosongkan isi table dulu
                $("#modalView table tbody").html(`
                    <tr>
                        <td colspan="5" class="text-center">Loading...</td>
                    </tr>
                `);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(res) {
                        if (res.data) {
                            let ticket = res.data;

                            // === handle attachment user & IT ===
                            let attachmentUser = '-';
                            let attachmentIT = '-';

                            if (ticket.attachments && ticket.attachments.length > 0) {
                                let userLinks = [];
                                let itLinks = [];

                                ticket.attachments.forEach(att => {
                                    let fileUrl = `/storage/${att.path}`;
                                    let isImage = /\.(jpg|jpeg|png|gif)$/i.test(att
                                        .path);

                                    let preview = isImage ?
                                        `<br><img src="${fileUrl}" class="img-thumbnail mt-1" style="max-height:120px;">` :
                                        '';

                                    if (att.request_id) {
                                        userLinks.push(`<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-success mb-1">
                                    <i class="fa fa-eye"></i> View
                                </a>`);
                                    }
                                    if (att.approve_id) {
                                        itLinks.push(`<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-success mb-1">
                                            <i class="fa fa-eye"></i> View
                                        </a>`);
                                    }
                                });

                                if (userLinks.length > 0) attachmentUser = userLinks.join(
                                    '<br>');
                                if (itLinks.length > 0) attachmentIT = itLinks.join('<br>');
                            }

                            // === isi table pertama (detail ticket) ===
                            let detailHtml = `
                                <tr>
                                    <td>1</td>
                                    <td style="font-weight: bold">${ticket.date ?? '-'}</td>
                                    <td style="font-weight: bold">${ticket.category?.name ?? '-'}</td>
                                    <td>${attachmentUser}</td>
                                    <td>${attachmentIT}</td>
                                </tr>
                                <tr>
                                    <th colspan="5" class="bg-primary text-white">DESCRIPTIONS</th>
                                </tr>
                                <tr>
                                    <td colspan="5">${ticket.desc ?? '-'}</td>
                                </tr>
                            `;
                            $("#modalView table").eq(0).find("tbody").html(detailHtml);

                            // === isi table kedua (history) ===
                            let historyHtml = "";
                            ticket.history.forEach((item, i) => {
                                historyHtml += `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${formatDate(item.date)}</td>
                                        <td class="${item.status ?? ''}">
                                            <span class="badge ${item.bg_color ?? ''}">${item.status?.name ?? '-'}</span>
                                        </td>
                                        <td>${item.remark ?? '-'}</td>
                                        <td>${formatDateTime(item.created_at)}</td>

                                    </tr>
                                `;
                            });

                            if (historyHtml === "") {
                                historyHtml = `
                            <tr>
                                <td colspan="5" class="text-center">No history</td>
                            </tr>
                        `;
                            }

                            $("#modalView table").eq(1).find("tbody").html(historyHtml);

                        } else {
                            $("#modalView table tbody").html(`
                        <tr><td colspan="5" class="text-center">Data not found</td></tr>
                    `);
                        }
                    },
                    error: function(xhr) {
                        $("#modalView table tbody").html(`
                    <tr><td colspan="5" class="text-danger text-center">Error load data</td></tr>
                `);
                    }
                });
            });


            // Update
            $(document).on("click", ".btn[data-bs-target='#modalUpdate']", function() {
                let id = $(this).data("id");
                let url = "{{ route('ticket.edit-data', ':id') }}".replace(':id', id);

                // simpan id ke hidden input
                $("#modalUpdate input[name='ticket_id']").val(id);

                $.get(url, function(res) {
                    if (res.data) {
                        let t = res.data;
                        $("#modalUpdate input[aria-describedby='helpId']").eq(0).val(t.no);
                        $("#modalUpdate input[aria-describedby='helpId']").eq(1).val(t.user?.name ??
                            '-');
                        $("#modalUpdate input[aria-describedby='helpId']").eq(2).val(t.date);
                        $("#modalUpdate #category_id").val(t.category_id);
                        $("#modalUpdate textarea#desc_history").val(t.desc);

                        // gunakan latestHistory (camelCase)
                        $("#modalUpdate input#date_history").val(t.latestHistory?.date ?? '');
                        $("#modalUpdate textarea#remark_history").val('');

                        // departement
                        $("#modalUpdate input[aria-describedby='helpId']").eq(3).val(
                            t.user?.groupuser?.department?.name ?? '-'
                        );
                    }
                });
            });

            // === submit form update ===
            $("#modalUpdate .btn-primary").on("click", function() {
                let id = $("#modalUpdate input[name='ticket_id']").val();
                let url = "{{ route('ticket.update-data', ':id') }}".replace(':id', id);

                let formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("_method", "PUT");
                formData.append("date", $("#date_history").val());
                formData.append("category_id", $("#category_id").val());
                formData.append("status_id", $("#status_edit_history").val());
                formData.append("desc", $("#desc_history").val());
                formData.append("remark", $("#remark_history").val());

                let files = $("#fileElem")[0].files;
                for (let i = 0; i < files.length; i++) {
                    formData.append("attachments[]", files[i]);
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        alert(res.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Update failed: " + (xhr.responseJSON?.message ??
                            "Unknown error"));
                    }
                });
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
                    <span>${file.name} <small class="text-muted">(${(file.size / 1024).toFixed(1)} KB)</small></span>
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
