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
						<img style="width: 100px;  height: auto;" src="{{ public_path('assets/KotaBandung.png') }}">
						
						<!-- <img style="width: 200px;  height: auto;" src="{{ asset('assets/Bandung.svg') }}"> -->
  					<!-- </div> -->
				<!-- </div>	 -->
			</td>
			<td>
				<div style="width: 100px;  height: auto;"></div>
			</td>
			<td>
				<center>
				<b>
					<font size="2">PEMERINTAH KOTA BANDUNG</font><BR>
					<font size="3">KECAMATAN {{strtoupper($kelurahan->kecamatan_nama)}}</font><BR>
					<font size="4">KELURAHAN {{strtoupper($kelurahan->kelurahan_nama)}}</font><BR>
					<font size="1">Alamat : {{ucwords($kelurahan->kelurahan_alamat)}} Tlp : (022)-{{$kelurahan->kelurahan_telepon}}</font>
				</b>
				</center>
			</td>
			<td>
				<div style="width: 100px;  height: auto;"></div>
			</td>
			<td>
				<div style="width: 100px;  height: auto;"></div>
			</td>
		</tr>
	</table>
	<hr width ="100%" size ="10">
	<table align="center">
		<tr>
			<td> <center><font size="14">VERIFIKASI DAN VALIDASI DATA TERPADU KESEJAHTERAAN SOSIAL<BR>
			 PENANGANAN FAKIR MISKIN DAN ORANG TIDAK MAMPU TAHUN 
			 <?php
			 	$year = date('Y');
				 echo $year;
			 ?></font></center> </td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
		<tr>
			<td><center><font size="15"><b>BERITA ACARA MUSYWARAH HASIL FORUM MUSYWARAH</b></font></center></td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
	</table>
	<p style= "margin-left:45px;"> Pada hari ini, 
	<?php
	$day = date("l"); 
	$hari = null;
	if($day == 'Sunday'){
		$hari = 'Minggu';
	}
	if($day == 'Monday'){
		$hari = 'Senin';
	}
	if($day == 'Tuesday'){
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
	
		<table style= "margin-left:95px;">
			<tr>
				<td><font size="12">Provinsi</font></td>
				<td><font size="12">:</font></td> 
				<td><font size="12">Jawa Barat</font></td>
			</tr>
			<tr>
				<td><font size="12">Kota</font></td>
				<td><font size="12">:</font></td> 
				<td><font size="12">Bandung</font></td>
			</tr>
			<tr>
				<td><font size="12">Kecamatan</font></td>
				<td><font size="12">:</font></td> 
				<td><font size="12">{{ucwords($kelurahan->kecamatan_nama)}}</font></td>
			</tr>
			<tr>
				<td><font size="12">Kelurahan</font></td>
				<td><font size="12">:</font></td> 
				<td><font size="12">{{ucwords($kelurahan->kelurahan_nama)}}</font></td>
			</tr>
			<tr>
			<td height ="20"></td>
		</table>
	
	<p style= "text-indent:45px; margin-left:45px;"> Berdasarkan hasil kegiatan tersebut, bahwa pada wilayah kami telah disepakati <BR>
	hasil pelaksanaan musyawarah Desa/Kelurahan sebagai berikut: </p>
	@php
		$data_a = 0;
		$data_b = 0;
		$data_c = 0;
		$data_d = 0;
		$total_data = 0;
		$data_baru = 0;
	@endphp
	@foreach($data as $dt)
		@if($dt->penduduk_status == 6 || $dt->penduduk_status == 4)
			@php
				$data_a += 1;
				$total_data += 1;
			@endphp
		@endif
		@if($dt->penduduk_status == 3)
			@php
				$data_b += 1;
				$total_data += 1;
			@endphp
		@endif
		@if($dt->penduduk_status == 1 || $dt->penduduk_status == 2)
			@php
				$data_c += 1;
				$total_data += 1;
			@endphp
		@endif
		@if($dt->penduduk_status == 8)
			@php
				$data_d += 1;
				$total_data += 1;
			@endphp
		@endif
		@if($dt->penduduk_status == 0)
			@php
				$data_baru += 1;
			@endphp
		@endif
	@endforeach
	<table style= "margin-left:95px;">
		<tr>
			<td><font size="12"> <b>1. Keberadaan dan Status Data Prelist</b> </font></td>
		</tr>
		<tr>
			<td><font size="12"> a. Jumlah Rumah Tangga Tidak Ditemukan </font></td>
			<td><font size="12"> : </font></td>
			<td><font size="12"> <?php echo $data_a; ?> </font></td>
			<td><font size="12"> Rumah Tangga </font></td>
		</tr>
		<tr>
			<td><font size="12"> b. Jumlah Rumah Tangga Mampu </font></td>
			<td><font size="12"> : </font></td>
			<td><font size="12"> <?php echo $data_b; ?> </font></td>	
			<td><font size="12"> Rumah Tangga </font></td>
		</tr>
		<tr>
			<td><font size="12"> c. Jumlah Rumah Tangga Pindah </font></td>			
			<td><font size="12"> : </font></td> 
			<td><font size="12"> <?php echo $data_c; ?> </font></td>
			<td><font size="12"> Rumah Tangga </font></td>
		</tr>
		<tr>
			<td><font size="12"> d. Jumlah Rumah Tangga Diperbaiki </font></td>		
			<td><font size="12"> : </font></td> 
			<td><font size="12"> <?php echo $data_d; ?> </font></td> 
			<td><font size="12"> Rumah Tangga </font></td>
		</tr>
		<tr>
			<td height ="20"></td>
		</tr>
		<tr>
			<td><font size="12"><b> Total Rumah Tangga Prelist </b></font></td>
			<td><font size="12"><b> : </b></font></td>
			<td><font size="12"><b> <?php echo $total_data; ?> </b></font></td>
			<td><font size="12"><b> Rumah Tangga </b></font></td>
		</tr>
		<tr>
			<td height = "20" ></td>
		</tr>
		<tr>
			<td><font size="12"><b>2. Jumlah Rumah Tangga Usulan Baru</b></font></td>
			<td><font size="12">:</font></td> 
			<td><font size="12"><?php echo $data_baru; ?></font></td> 
			<td><font size="12">Rumah Tangga</font></td>
		</tr>
		<tr>
			<td height = "20"></td>
		</tr>
	</table>

	<p style = "text-indent:45px;">Demikian berita acara ini dibuat untuk digunakan sebagaimana mestinya.</P>


		<table align='center'>
			<tr>
				<td>
				<div style="width: 75px;  height: auto;"></div>
				</td>
				<td>
				<center>
				LURAH {{strtoupper($kelurahan->kelurahan_nama)}}
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
				<div style="width: 75px;  height: auto;"></div>
				</td>
			</tr>
			<tr>
				<td>
				<br>
				<br>
				<br>
				<br>
				<div style="width: 50px;  height: auto;"></div>
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
		<br><br><br><br><br>
 	<center>
		<h4>Laporan Prelist Akhir Musyawarah Kelurahan</h4>
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