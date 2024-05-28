@extends('layouts.simple.master')
@section('title', 'Product')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/range-slider.css')}}">
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/range-slider.css')}}">
<style>
  .product-grid .row {
  display: flex;
  flex-wrap: wrap;
}

.product-grid .row > [class*='col-'] {
  display: flex;
  flex-direction: column;
}
</style>
@endsection

@section('breadcrumb-title')
<h3>Product</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Ecommerce</li>
<li class="breadcrumb-item active">Product</li>
@endsection

@section('content')
<div class="container-fluid product-wrapper">
   <div class="product-grid">
     <div class="feature-products">
       <div class="row">
         <div class="col-md-12">
          <form action="{{ route('produk') }}" method="GET">
            <div class="form-group m-0">
                <input class="form-control" type="search" name="search" placeholder="Search.." data-original-title="" title="">
                <i class="fa fa-search"></i>
            </div>
          </form>
         </div>
       </div>
     </div>
     <div class="product-wrapper-grid">
       <div class="row">
         @foreach($products as $product)
         <div class="col-xl-3 col-sm-6 xl-4">
           <div class="card">
             <div class="product-box">
               <div class="product-img">
                 <img class="img-fluid" src="{{ $product->fotoProduk }}" alt="">
                 <div class="product-hover">
                   <ul>
                     <li>
                       <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{ $product->id }}">
                         <i class="icon-eye"></i>
                       </button>
                     </li>
                   </ul>
                 </div>
               </div>
               <div class="modal fade" id="exampleModalCenter{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter{{ $product->id }}" aria-hidden="true">
                 <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <div class="modal-header">
                       <div class="product-box row">
                         <div class="product-img col-lg-6">
                           <img class="img-fluid" src="{{ $product->fotoProduk }}" alt="">
                         </div>
                         <div class="product-details col-lg-6 text-start">
                           <h4>{{ $product->namaProduk }}</h4>
                           <div class="product-price">Rp{{ $product->hargaProduk }}</div>
                           <div class="product-view">
                             <h6 class="mb-0 f-w-600">Stok</h6>
                             <p class="txt-success">
                                @if ($product->stokProduk)
                                    Tersedia
                                @else
                                    Tidak Tersedia
                                @endif
                             </p>
                             <h6 class="mb-0 f-w-600">Berat</h6>
                             <p>{{ $product->beratProduk }} gram</p>
                             <h6 class="mb-0 f-w-600">Kategori</h6>
                             <p>{{ $product->kategoriProduk }}</p>
                           </div>
                           <div class="product-view">
                             <h6 class="f-w-600">Deskripsi Produk</h6>
                             <p class="mb-0">{{ $product->deskripsiProduk }}</p>
                           </div>
                           <div class="product-qnty">
                             <div class="addcart-btn">
                                <a class="btn btn-primary" href="{{ route('order', ['product' => $product->id, 'reseller' => auth()->user()->reseller->id]) }}">Order</a>
                             </div>
                           </div>
                         </div>
                       </div>
                       <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                   </div>
                 </div>
               </div>
               <div class="product-details">
                  <h4>{{ $product->namaProduk }}</h4>
                  <p>{{ $product->deksripsiProduk }}</p>
                  <p class="mt-0 txt-success">
                    @if ($product->stokProduk)
                        Tersedia
                    @else
                        Tidak Tersedia
                    @endif
                  </p>
                  <p>{{ $product->beratProduk }} gram</p>
                  <div class="product-price">Rp{{ $product->hargaProduk }}</div>
               </div>
             </div>
           </div>
         </div>
         @endforeach
       </div>
     </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/range-slider/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('assets/js/range-slider/rangeslider-script.js')}}"></script>
<script src="{{asset('assets/js/touchspin/vendors.min.js')}}"></script>
<script src="{{asset('assets/js/touchspin/touchspin.js')}}"></script>
<script src="{{asset('assets/js/touchspin/input-groups.min.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/js/product-tab.js')}}"></script>
@endsection
