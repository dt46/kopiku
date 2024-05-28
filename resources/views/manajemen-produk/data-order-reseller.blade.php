@extends('layouts.simple.master')
@section('title', 'Daftar Pesanan')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/date-picker.css">
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/tom-select.bootstrap5.css">
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/select2.css">
<link rel="stylesheet" href="/assets/js/datatable/dataTables.dataTables.min.css">
<link rel="stylesheet" href="/assets/js/datatable/fixedColumns.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/sweetalert2.min.css">

<style>
    table.dataTable thead th {
        text-align: center !important;
        vertical-align: middle !important;
    }

    div.dt-scroll-body thead tr,
    div.dt-scroll-body thead th {
        border-bottom-width: 0 !important;
        border-top-width: 0 !important;
    }

    div.dt-scroll-body::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    div.dt-scroll-body::-webkit-scrollbar {
        width: 4px;
        background-color: #F5F5F5;
    }

    div.dt-scroll-body::-webkit-scrollbar-thumb {
        background-color: #6c757d;
    }

    .card-body,
    .card-body input,
    .card-body select,
    .card-body table,
    table {
        font-size: .8rem !important;
    }

    th {
        font-weight: 500 !important;
    }

    .datepicker {
        z-index: 1600 !important;
    }

    #tabel-daftar-order th,
    #tabel-daftar-order td {
        text-align: center;
        vertical-align: middle;
    }
</style>
@endsection

@section('breadcrumb-title')
<h3>Daftar Pesanan</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Daftar Pesanan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pesanan</h5>
                        <div>
                            <button class="btn btn-sm btn-info px-3" style="color: white;" id="ubah-data-agen" type="button">Proses</button>
                        </div>
                    </div>
                </div>
                <div class="card-body"> 
                    <table id="tabel-daftar-order" class="nowrap table table-striped table-bordered border-secondary">
                    <thead>
                            <tr>
                                <th rowspan="2"></th>
                                <th colspan="3">Produk</th>
                                <th rowspan="2">Banyak Item</th>
                                <th rowspan="2">Total Harga</th>
                                <th rowspan="2">No Resi</th>
                                <th rowspan="2">Status</th>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Edit Data --}}
<div class="modal fade bd-example-modal-lg ubah-data-agen" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Proses Barang</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-agen" action="" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <input type="text" id="id" hidden>
                            <div class="mb-3">
                                <label class="col-form-label">Status</label>
                                <select class="form-control form-select" name="status" id="status" required>
                                    <option value="dikirim" disabled>Dikirim</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="batal-agen"
                    data-bs-dismiss="modal">Batalkan</button>
                <button type="button" id="simpan-agen"
                    class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/select2/select2.full.min.js"></script>
<script src="/assets/js/select2/select2-custom.js"></script>
<script src="/assets/js/tom-select/tom-select.complete.min.js"></script>
<script src="/assets/js/datatable/dataTables.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/dataTables.fixedColumns.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="/assets/js/sweet-alert/sweetalert2.all.min.js"></script>
<script src="/assets/js/height-equal.js"></script>

<script>
(function(){
    const tableorder = new DataTable('#tabel-daftar-order', {
        fixedColumns: true,
        scrollX: true,
        dom: 'Bfrtip',
        searching: true, 
        buttons: [],
        ajax: {
            url: '/daftar-pesanan',
            type: 'GET',
            dataSrc: function (json) {
                return json.data;
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
                className: 'text-center'
            },
            { 
                data: 'fotoProduk',
                render: function (data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" style="max-width: 50px; max-height: 50px;">';
                    }
                    return ''; 
                }
            },
            { data: 'namaProduk' },
            { 
                data: 'hargaProduk',
                render: function (data, type, row) {
                    return 'Rp' + data;
                }
            },
            { data: 'banyak_item' },
            { 
                data: 'total_harga',
                render: function (data, type, row) {
                    return 'Rp' + data;
                }
            },
            { 
                data: 'no_resi',
                render: function (data, type, row) {
                    return data ? data : 'No Resi Belum di Berikan';
                }
            },
            { 
                data: 'status',
                render: function (data, type, row) {
                    let badgeClass = '';
                    let statusText = '';
                    if (data === 'verifikasi') {
                        badgeClass = 'badge-danger';
                        statusText = 'Verifikasi';
                    } else if (data === 'dikirim') {
                        badgeClass = 'badge-warning';
                        statusText = 'Dikirim';
                    } else if (data === 'diterima') {
                        badgeClass = 'badge-info';
                        statusText = 'Diterima';
                    } else {
                        badgeClass = 'badge-success';
                        statusText = 'Selesai'
                    }
                    return '<span class="badge ' + badgeClass + '">' + statusText + '</span>';
                }
            },
        ],
        columnDefs: [
            {
                visible: false,
            },
        ]
    });

    tableorder.on('click', 'tbody tr', (e) => {
        let classList = e.currentTarget.classList;

        if (classList.contains('selected')) {
            classList.remove('selected');
        }
        else {
            tableorder.rows('.selected').nodes().each((row) => row.classList.remove('selected'));
            classList.add('selected');
        }
    });

    const modalUbahAgen = new bootstrap.Modal(document.querySelector('.ubah-data-agen'), {
        keyboard: false
    });
    $('button#ubah-data-agen').on('click', function(){
        const idAgen = tableorder.row('.selected').id();
        idAgen ? modalUbahAgen.show() : modalUbahAgen.hide();
    });
    $('.ubah-data-agen').on('shown.bs.modal', function() {
        idAgen = tableorder.row('.selected').data().id;
        $.ajax({
            url: '/update-status-order/' + idAgen,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                data = response.data;
                $('#id').val(data.id);
                $('#no_resi').val(data.no_resi);
                if (data.status) {
                    $('#status').val("verifikasi"); 
                } else if (data.status) {
                    $('#status').val("dikirim");
                } else if (data.status) {
                    $('#status').val("diterima");
                } else {
                    $('#status').val("selesai");
                }
            },
            error: function(error){
                console.error(error);
            }
        })

        function toggleStatusBtn(disabled, buttonsSelector) {
            $(buttonsSelector).prop('disabled', disabled);
        }

        toggleStatusBtn(true, '#simpan-agen');

        $(".form-control").on('change input', function() {
            toggleStatusBtn(false, "#simpan-agen")
        });

        $('#simpan-agen').off('click').on('click', function(){
            $('#form-agen').submit();
        });

        $('#form-agen').off('submit').on('submit', function(e){
            e.preventDefault();

            toggleStatusBtn(true, '#batal-agen, #simpan-agen');

            let formData = new FormData($(this)[0]);
            let plainFormData = {};

            formData.forEach(function(value, key){
                plainFormData[key] = value;
            });

            $.ajax({
                url: '/update-status-order/' + idAgen,
                method: 'PUT',
                data: JSON.stringify(plainFormData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.ubah-data-agen').modal('hide');

                    let _msgTitle = response.status ? 'Berhasil' : 'Gagal';
                        let _msg = response.status ? 'Status Berhasil diperbaharui' : 'Gagal memperbarui status, terdapat kesalahan sistem.';
                        let _icon = response.status ? 'success' : 'error';

                        Swal.fire({
                            title: _msgTitle,
                            text: _msg,
                            position: "center",
                            showConfirmButton: false,
                            icon: _icon,
                            timer: 2000
                        });

                    tableorder.ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            }).done(function(){
                toggleStatusBtn(false, '#batal-agen, #simpan-agen');
            });

        });
    });
})();
</script>

@endsection