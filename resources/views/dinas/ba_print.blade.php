<!DOCTYPE html>
<html>
<head>
	<title>Berita Acara dan Prelist Akhir Musywarah Kelurahan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
</head>
<body>
	<table align="center">
		<tr>
			<td>
				<!-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0"> -->
					<!-- <div > -->
						<img style="width: 200px;  height: auto;" src="{{ public_path('assets/KotaBandung.png') }}">
						
						<!-- <img style="width: 200px;  height: auto;" src="{{ asset('assets/Bandung.svg') }}"> -->
  					<!-- </div> -->
				<!-- </div>	 -->
			</td>
			<td>
				<center>
				<b>
					<font size="2">PEMERINTAH KOTA BANDUNG</font><BR>
					<font size="3">KECAMATAN {{$kelurahan->kecamatan_nama}}</font><BR>
					<font size="4">KELURAHAN {{$kelurahan->kelurahan_nama}}</font><BR>
					<font size="1">Alamat : {{$kelurahan->kelurahan_alamat}} Tlp : {{$kelurahan->kelurahan_telepon}}</font>
				</b>
				</center>
			</td>
			<td>
				<div style="width: 200px;  height: auto;"></div>
			</td>
		</tr>
	</table>
	<hr width ="100%" size ="10">
	<table align="center">
		<tr>
			<td> <center>VERIFIKASI DAN VALIDASI DATA TERPADU KESEJAHTERAAN SOSIAL<BR>
			 PENANGANAN FAKIR MISKIN DAN ORANG TIDAK MAMPU TAHUN 
			 <?php
			 	$year = date('Y');
				 echo $year;
			 ?></center> </td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
		<tr>
			<td><b><center>BERITA ACARA MUSYWARAH HASIL FORUM MUSYWARAH</center></b></td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
	</table>
	<p style= "text-indent:45px;"> Pada hari ini, 
	<?php
	$day = date("l"); 
	$hari = null;
	if($day == 'Sunday'){
		$hari = 'Minggu';
	}
	if($day == 'Monday'){
		$hari = 'Senin';
	}
	if($day == 'Teusday'){
		$hari = 'Selasa';
	}
	if($day == 'Wednesday'){
		$hari = 'Rabu';
	}
	if($day == 'Thursday'){
		$hari = 'Kamis';
	}
	if($day == 'Friday'){
		$hari = 'Jumat';
	}
	if($day == 'Saturday'){
		$hari = 'Sabtu';
	}
	 echo $hari;
	?> tanggal 
	<?php
		$date = date('d-m');
		echo $date . '-' . $year;
	?> telah dilaksanakan musyawarah. </p>
	<table>
		<tr>
			<td>Provinsi</td>
			<td>:</td> 
			<td>Jawa Barat</td>
		</tr>
		<tr>
			<td>Kota</td>
			<td>:</td> 
			<td>Bandung</td>
		</tr>
		<tr>
			<td>Kecamatan</td>
			<td>:</td> 
			<td>{{$kelurahan->kecamatan_nama}}</td>
		</tr>
		<tr>
			<td>Kelurahan</td>
			<td>:</td> 
			<td>{{$kelurahan->kelurahan_nama}}</td>
		</tr>
		<tr>
		<td height ="20"></td>
	</table>
	<p style= "text-indent:45px;"> Berdasarkan hasil kegiatan tersebut, bahwa pada wilayah kami telah disepakati <BR>
	hasil pelaksanaan musyawarah Desa/Kelurahan sebagai berikut: </p>
	<table>
		<tr>
			<td> 1. Keberadaan dan Status Data Prelist </td>
		</tr>
		<tr>
			<td> a. Jumlah Rumah Tangga Tidak Ditemukan </td>
			<td> : </td>
			<td> [Count penduduk_status = '6' and '4'] </td>
			<td> Rumah Tangga </td>
		</tr>
		<tr>
			<td> b. Jumlah Rumah Tangga Mampu </td>
			<td> : </td>
			<td> [Count penduduk_status = '3'] </td>	
			<td> Rumah Tangga </td>
		</tr>
		<tr>
			<td> c. Jumlah Rumah Tangga Pindah </td>			
			<td> : </td> 
			<td> [Count penduduk_status = '1' and '2'] </td>
			<td> Rumah Tangga </td>
		</tr>
		<tr>
			<td> d. Jumlah Rumah Tangga Diperbaiki </td>		
			<td> : </td> 
			<td> [Count penduduk_status = '8'] </td> 
			<td> Rumah Tangga </td>
		</tr>
		<tr>
			<td height ="20"></td>
		</tr>
		<tr>
			<td><b> Total Rumah Tangga Prelist </b></td>
			<td><b> : </b></td>
			<td><b> [Total Count] </b></td>
			<td><b> Rumah Tangga </b></td>
		</tr>
		<tr>
			<td height = "20" ></td>
		</tr>
		<tr>
			<td>2. Jumlah Rumah Tangga Usulan Baru</td>
			<td>:</td> 
			<td>[Count penduduk_status = '0']</td> 
			<td>Rumah Tangga</td>
		</tr>
		<tr>
			<td height = "25"></td>
		</tr>
	</table>

	<p style = "text-indent:45px;">Demikian berita acara ini dibuat untuk digunakan sebagaimana mestinya.</P>


		<table align='center'>
			<tr>
				<td>
				<center>
				LURAH [kelurahan_nama]
				</center>
				</td>
				<td>
				<div style="width: 200px;  height: auto;"></div>
				</td>
				<td>
				<center>
				Kota Bandung, <?php
				echo date('d-m') . '-' . $year;?> <br>
				PETUGAS
				</center>
				</td>
				<td>
				<div style="width: 200px;  height: auto;"></div>
				</td>
			</tr>
			<tr>
				<td>
				<br>
				<br>
				<br>
				<br>
				<center>
				(..........................................)
				</center>
				</td>
				<td>
				<div style="width: 200px;  height: auto;"></div>
				</td>
				<td>
				<br>
				<br>
				<br>
				<br>
				<center>
				(..........................................)
				</center>
				</td>
				<td>
				<div style="width: 200px;  height: auto;"></div>
				</td>
			</tr>

		</table>
																	<!-- Kota Bandung [Tanggal]
		LURAH [kelurahan_nama]												PETUGAS




		
		(.....................)										(.......................) -->
		<br><br><br><br><br><br><br><br><br>
 	<center>
		<h4>Laporan Prelist Akhir Musyarah Kelurahan</h4>
	</center>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>NIK</th>
				<th>BDT</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Status</th>
				<th>Deskripsi</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($data as $dt)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{$dt->penduduk_nik}}</td>
				@if($dt->penduduk_id_bdt)
					<td>{{$dt->penduduk_id_bdt}}</td>
				@else
                    <td>Belum Ada</td>
                @endif
				<td>{{$dt->penduduk_nama}}</td>
				<td>{{$dt->penduduk_alamat}}</td>
				<td>{{$dt->deskripsi}}</td>
				<td>{{$dt->penduduk_deskripsi}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>