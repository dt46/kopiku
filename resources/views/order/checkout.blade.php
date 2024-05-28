@extends('layouts.simple.master')
@section('title', 'Checkout')

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/css/vendors/sweetalert2.min.css">

<style>
    .checkout .card {
        margin: 20px 0;
    }
    .checkout .card-header {
        padding: 10px 20px;
    }
    .checkout .card-body {
        padding: 20px;
    }
    .checkout .form-control {
        height: auto;
        padding: 5px 10px;
        font-size: 14px;
    }
    .checkout .mb-3 {
        margin-bottom: 10px;
    }
    .checkout .order-box .qty li,
    .checkout .order-box .sub-total li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
    }
    .checkout .order-box .title-box {
        margin-bottom: 10px;
    }
    .checkout .order-box .upload-payment {
        padding: 10px 0;
    }
    .checkout .order-box .total {
        font-weight: bold;
    }
    .checkout .quantity-input {
        width: 50px;
        display: inline-block;
        margin: 0 5px;
    }
    .order-place {
        margin-top: 20px;
    }
</style>
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Checkout</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Ecommerce</li>
<li class="breadcrumb-item active">Checkout</li>
@endsection

@section('content')
<div class="container-fluid checkout">
   <div class="card">
      <div class="card-header">
         <h5>Billing Details</h5>
      </div>
      <div class="card-body">
         @if (session('res-status'))
            <div class="alert alert-{{ session('res-status')['status'] }}">
               {{ session('res-status')['msg'] }}
            </div>
         @endif
         <div class="row">
            <div class="col-xl-6 col-sm-12">
               <form>
                  <div class="mb-3">
                     <label for="nama">Nama</label>
                     <input class="form-control" id="nama" type="text" name="nama" value="{{ $reseller->nama }}" disabled readonly>
                  </div>
                  <div class="mb-3">
                     <label for="no_hp">No Handphone</label>
                     <input class="form-control" id="no_hp" type="number" name="no_hp" value="{{ $reseller->no_hp }}" disabled readonly>
                  </div>
                  <div class="mb-3">
                     <label for="alamat_detail">Alamat</label>
                     <input class="form-control" id="alamat_detail" type="text" name="alamat_detail" value="{{ $reseller->alamat_detail }}" disabled readonly>
                  </div>
               </form>
            </div>
            <div class="col-xl-6 col-sm-12">
               <div class="checkout-details">
                  <div class="order-box">
                     <div class="title-box">
                        <div class="checkbox-title">
                           <h4>Product</h4>
                           <span>Total</span>
                        </div>
                     </div>
                     <ul class="qty">
                        @foreach($products as $product)
                        <li>{{ $product->namaProduk }} × 
                            <input class="form-control quantity-input" type="number" value="1" name="banyak_item" id="banyak_item" min="1" max="10" data-price="{{ $product->hargaProduk }}" data-id="{{ $product->id }}">
                            <span>Rp{{ $product->hargaProduk }}</span>
                        </li>
                        @endforeach
                     </ul>
                     <ul class="sub-total">
                        <li>Subtotal <span class="count" id="subtotal">Rp0.00</span></li>
                        <li>Ongkos Kirim <span class="count">Rp10,000.00</span></li>
                     </ul>
                     <div class="mb-3 bank-details">
                        <h6>Nomor Rekening untuk Transfer:</h6>
                        <p>Bank BCA: 1234-5678-9012</p>
                        <p>Bank BNI: 9876-5432-1098</p>
                     </div>
                     <div class="mb-5 upload-payment">
                        <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                        <input class="form-control" id="bukti_pembayaran" type="file" name="bukti_pembayaran">
                     </div>
                     <ul class="sub-total total">
                        <li>Total <span class="count" id="total">0</span></li>
                     </ul>
                     <div class="order-place"><a class="btn btn-primary" href="#">Place Order</a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script src="/assets/js/sweet-alert/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shippingCost = 10000;

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.quantity-input').forEach(function (input) {
            const price = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value);
            subtotal += price * quantity;
        });
        const total = subtotal + shippingCost;
        document.getElementById('subtotal').innerText = 'Rp' + subtotal.toFixed(2);
        document.getElementById('total').innerText = 'Rp' + total.toFixed(2);
    }

    document.querySelectorAll('.quantity-input').forEach(function (input) {
        input.addEventListener('change', function () {
            updateTotals();
        });
    });

    updateTotals();

   $('.order-place').on('click', function () {
      const user_id = '{{ $reseller->id }}'; 
      const product_id = '{{ $product->id }}';
      const ongkos_kirim = 10000; 
      const total_harga = parseInt(document.getElementById('total').innerText.replaceAll(',', '').replace(/[^\d.-]/g, ''));
      const formData = new FormData();
      formData.append('user_id', user_id);
      formData.append('ongkos_kirim', ongkos_kirim);
      formData.append('total_harga', total_harga);
      formData.append('product_id', product_id);
      formData.append('banyak_item', document.getElementById('banyak_item').value);
      formData.append('bukti_pembayaran', document.getElementById('bukti_pembayaran').files[0]);


      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': csrfToken
         }
      });
      $.ajax({
         url: '/store-order',
         method: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function (response) {
            let _msgTitle = response.status ? 'Berhasil' : 'Gagal';
            let _msg = response.status ? 'Order Berhasil' : 'Gagal Order, terdapat kesalahan sistem.';
            let _icon = response.status ? 'success' : 'error';

            Swal.fire({
               title: _msgTitle,
               text: _msg,
               position: "center",
               showConfirmButton: false,
               icon: _icon,
               timer: 2000
            }).then(() => {
               if (response.status) {
                  window.location.href = '/daftar-pesanan';
               }
            });
         },
         error: function (error) {
            console.error('There was a problem with your ajax request:', error);
         }
      });
      console.log(formData);
   });
});
</script>
@endsection
