<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pengajuan Bansos Kelurahan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	DISINI
	[tanggal]
	<center>
		<h4>Laporan Pengajuan Bansos Kelurahan</h4>
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