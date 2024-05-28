@extends('layouts.simple.master')
@section('title', 'Profile')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/date-picker.css">
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/tom-select.bootstrap5.css">
<link rel="stylesheet" href="/assets/js/datatable/dataTables.dataTables.min.css">
<link rel="stylesheet" href="/assets/js/datatable/fixedColumns.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/sweetalert2.min.css">

<style>
.rounded-circle {
    margin: auto;
    display: block; 
    border-radius: 50%;
}
</style>
@endsection

@section('breadcrumb-title')
<h3>Profile</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Profile</h5>
        </div>
        <div class="card-body">
            <form id="form-update-reseller" class="theme-form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 text-center">
                    @if(auth()->user()->reseller->foto_profil)
                    <div class="mt-2 rounded-circle overflow-hidden mx-auto" style="width: 200px; height: 200px;">
                        <img src="{{ auth()->user()->reseller->foto_profil }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;" class="rounded-circle">
                    </div>
                    @endif
                    <label class="col-form-label pt-3" for="foto_profil">Foto Profil</label>
                    <input class="form-control" id="foto_profil" name="foto_profil" type="file">
                </div>
                <div class="mb-3">
                    <label class="col-form-label pt-0" for="email">Email</label>
                    <input
                        value="{{ auth()->user()->role->name == 'reseller' ? auth()->user()->email : old('email') }}"
                        class="form-control" id="email" type="email" disabled>
                </div>
                <div class="mb-3">
                    <label class="col-form-label pt-0" for="no_registration">Nama</label>
                    <input
                        value="{{ auth()->user()->role->name == 'reseller' ? auth()->user()->reseller->nama : old('nama') }}"
                        class="form-control" id="nama" name="nama" type="text">
                </div>
                <div class="mb-3">
                    <label class="col-form-label pt-0" for="nama_agen">Nama Handphone</label>
                    <input
                        value="{{ auth()->user()->role->name == 'reseller' ? auth()->user()->reseller->no_hp : old('no_hp') }}"
                        class="form-control" id="no_hp" name="no_hp" type="text">
                </div>
                <div class="mb-3">
                    <label class="col-form-label pt-0" for="alamat">Alamat Detail</label>
                    <input
                        value="{{ auth()->user()->role->name == 'reseller' ? auth()->user()->reseller->alamat_detail : old('alamat_detail') }}"
                        class="form-control" id="alamat_detail" name="alamat_detail" type="text">
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-secondary" id="btn-update-reseller">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/select2/select2.full.min.js"></script>
<script src="/assets/js/select2/select2-custom.js"></script>
<script src="/assets/js/datatable/dataTables.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
<script src="/assets/js/datatable/datatable-extension/dataTables.fixedColumns.min.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="/assets/js/sweet-alert/sweetalert2.all.min.js"></script>

<script>
    (function () {
        $('#btn-update-reseller').click(function () {
            var formData = $('#form-update-reseller').serialize();
            $.ajax({
                url: '/update-profile-reseller',
                type: 'POST', 
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: response.error,
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(status, xhr, error)
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengirim permintaan.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    })();
</script>
@endsection
