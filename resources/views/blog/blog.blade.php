@extends('layouts.simple.master')
@section('title', 'Home')

@section('css')
@endsection

@section('style')
<style>
.blog-list p {
	text-align: justify;
	margin: 20px; 
}
</style>
@endsection

@section('breadcrumb-title')
<h3>Kopiku</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-6 set-col-12 box-col-12">
			<div class="card">
				<div class="blog-box blog-shadow">
					<img class="img-fluid" src="{{asset('assets/images/biji_kopi.jpg')}}" alt="">
					<div class="blog-details">
						<h4>Selamat Datang DiKopiku.</h4>
						<p>Kopi memiliki sejarah panjang yang dimulai di Ethiopia pada abad ke-9, di mana seorang penggembala kambing bernama Kaldi menemukan bahwa kambingnya menjadi lebih energik setelah memakan buah kopi. Dari sana, kopi menyebar ke Arab pada abad ke-15, terutama di Yaman, di mana ia diproses dan disebarluaskan melalui perdagangan oleh para pedagang Arab. Pada abad ke-16, kopi mencapai Timur Tengah, Persia, Turki, dan Afrika Utara, serta akhirnya tiba di Eropa melalui Venesia pada awal abad ke-17. Kopi kemudian menyebar ke Amerika pada pertengahan abad ke-17 melalui koloni-koloni Eropa, dan sejak itu, telah menjadi salah satu minuman paling populer di dunia, dengan berbagai teknik budidaya dan penyeduhan yang terus berkembang hingga kini.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6 set-col-12 box-col-12">
			<div class="card">
				<div class="blog-box blog-list">
						<p>Kopi memiliki sejarah panjang yang dimulai di Ethiopia pada abad ke-9, di mana seorang penggembala kambing bernama Kaldi menemukan bahwa kambingnya menjadi lebih energik setelah memakan buah kopi. Dari sana, kopi menyebar ke Arab pada abad ke-15, terutama di Yaman, di mana ia diproses dan disebarluaskan melalui perdagangan oleh para pedagang Arab. Pada abad ke-16, kopi mencapai Timur Tengah, Persia, Turki, dan Afrika Utara, serta akhirnya tiba di Eropa melalui Venesia pada awal abad ke-17. Kopi kemudian menyebar ke Amerika pada pertengahan abad ke-17 melalui koloni-koloni Eropa, dan sejak itu, telah menjadi salah satu minuman paling populer di dunia, dengan berbagai teknik budidaya dan penyeduhan yang terus berkembang hingga kini.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-xl-4 set-col-4">
				<div class="card">
					<div class="blog-box blog-grid text-center">
						<img class="img-fluid top-radius-blog" src="{{asset('assets/images/arabica.jpg')}}" alt="">
						<div class="blog-details-main">
							<h6 class="blog-bottom-details">Arabika</h6>
							<hr>
							<p style="text-align: justify; margin: 20px;">
								- Ciri-ciri: Arabika memiliki rasa yang lebih halus, asam yang lebih tinggi, dan kompleksitas rasa yang lebih kaya dibandingkan dengan Robusta.<br>
								- Kondisi Tumbuh: Tumbuh di ketinggian yang lebih tinggi (sekitar 800-2000 meter di atas permukaan laut), membutuhkan iklim yang sejuk dan curah hujan yang cukup.<br>
								- Produksi: Menyumbang sekitar 60-70% produksi kopi dunia.<br>
								- Asal: Berasal dari Ethiopia, namun kini juga banyak ditanam di Amerika Latin, Afrika Timur, dan Asia.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-xl-4 set-col-4">
				<div class="card">
					<div class="blog-box blog-grid text-center">
						<img class="img-fluid top-radius-blog" src="{{asset('assets/images/robusta.jpg')}}" alt="">
						<div class="blog-details-main">
							<h6 class="blog-bottom-details">Robusta</h6>
							<hr>
							<p style="text-align: justify; margin: 20px;">
								- Ciri-ciri: Rasa lebih kuat dan lebih pahit dibandingkan Arabika, dengan kandungan kafein yang lebih tinggi. Sering digunakan dalam kopi instan dan espresso. <br>
								- Kondisi Tumbuh: Tumbuh di ketinggian yang lebih rendah (sekitar 0-800 meter di atas permukaan laut), lebih tahan terhadap penyakit dan kondisi cuaca ekstrem.<br>
								- Produksi: Menyumbang sekitar 30-40% produksi kopi dunia.<br>
								- Asal: Berasal dari Afrika Barat dan Tengah, tetapi kini juga banyak ditanam di Asia Tenggara (seperti Vietnam dan Indonesia) dan Brasil.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-xl-4 set-col-4">
				<div class="card">
					<div class="blog-box blog-grid text-center">
						<img class="img-fluid top-radius-blog" src="{{asset('assets/images/liberica.jpg')}}" alt="">
						<div class="blog-details-main">
							<h6 class="blog-bottom-details">Liberika</h6>
							<hr>
							<p style="text-align: justify; margin: 20px;">
								- Ciri-ciri: Biji lebih besar dan lebih tahan penyakit. Memiliki rasa yang unik, sedikit woody atau beraroma buah. <br>
								- Kondisi Tumbuh: Tumbuh di dataran rendah dan mampu bertahan dalam kondisi panas yang ekstrim dan tanah yang kurang subur. <br>
								- Produksi: Jumlah produksi relatif kecil dibandingkan Arabika dan Robusta. <br>
								- Asal: Berasal dari Liberia, Afrika Barat, dan kini ditanam di beberapa bagian Asia Tenggara, terutama di Filipina.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')

@endsection