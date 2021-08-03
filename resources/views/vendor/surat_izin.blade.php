<!DOCTYPE html>
<html>
<head>
	<title>contoh surat pengunguman</title>
	<style type="text/css">
		table {
			border-style: double;
			border-width: 3px;
			border-color: white;
		}
		table tr .text2 {
			text-align: right;
			font-size: 13px;
		}
		table tr .text {
			text-align: center;
			font-size: 13px;
		}
		table tr td {
			font-size: 13px;
		}

	</style>
</head>
<body>
	@foreach ($user as $u)
		@if ($u->email == $surat_izin[0]->penyewa)
			@php
				$penyewa = $u->name;
			@endphp
		@endif
		@if ($u->email == $surat_izin[0]->email)
			@php
				$vendor = $u->name;
			@endphp
		@endif
	@endforeach

	@foreach ($data_vendor as $u)
		@if ($u->email == $surat_izin[0]->email)
			@php
				$alamat = $u->alamat;
			@endphp
		@endif
	@endforeach

	@php
		$lama_sewa = $surat_izin[0]->lama_sewa * 30;
        $tgl_penurunan = date('Y-m-d', strtotime((date($surat_izin[0]->tgl_pesan)) . "+ $lama_sewa day"));
	@endphp
	<center>
		<table>
			<tr>
				<td><img src="{{ public_path('assets/img/logo.jpeg') }}" width="90" height="90"></td>
				<td>
				<center>
					<font size="4">PEMERINTAH KOTA JAYAPURA</font><br>
					<font size="5"><b>DINAS PENANAMAN MODAL</b></font><br>
					<font size="5"><b>DAN PELAYANAN TERPADU SATU PINTU</b></font><br>
					<font size="2">
						<i>
							Jl. Dr. Sam Ratulangi, Mandala, Jayapura Utara, Kota Jayapura, Papua
						</i>
					</font>
				</center>
				</td>
			</tr>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
            <table width="100%">
                <tr>
                    <td>
                        <td class="text2">Kode Pos 99221</td>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>
						<center>
							<font size="3">KEPUTUSAN KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</font><br>
							<font size="3">KOTA JAYAPURA</font><br>
							<font size="4"><b>TENTANG</b></font><br>
							<font size="4"><b>PEMBERIAN IZIN PENYELENGGARA REKLAME</b></font><br>
						</center>
                    </td>
                </tr>
            </table>
		</table>
		<br>
		<table>
			<tr>
		    	<td>
			    	<font size="2">
						Yang bertanda tangan di bawah ini Kepala Dinas Penanaman Modan dan Pelayanan Terpadu Satu Pintu Kota Jayapura
					</font>
		    	</td>
		    </tr>
		</table>

		<br>
		<table>
			<tr class="text2">
		    	<td style="width: 50%;">
			    	<center>
						<font size="3">MEMUTUSKAN</font>
					</center>
		    	</td>
		    </tr>
		</table>
		<br>
		<table>
			<tr class="text2">
				<td style="width: 30%;">KESATU :</td>
			</tr>
			<tr class="text2">
				<td style="width: 30%;">Memberikan Izin Penyelenggara Reklame kepada :</td>
			</tr>
			<tr class="text2">
				<td style="width: 30%;">Nama Pemegang Surat Izin</td>
				<td style="width: 65%;">: <b>{{$vendor}}</b></td>
			</tr>
			<tr class="text2">
				<td style="width: 30%;">Alamat Pemegang Surat Izin</td>
				<td style="width: 65%;">: <b>{{$alamat}}</b></td>
			</tr>
			<tr>
				<td style="width: 30%;">Jenis Reklame</td>
				<td style="width: 65%;">: {{$surat_izin[0]->nama_reklame}}</td>
			</tr>
			<tr>
				<td style="width: 30%;">Ukuran</td>
				<td style="width: 65%;">: {{$surat_izin[0]->ukuran}}</td>
			</tr>
			<tr>
				<td style="width: 30%;">Lokasi Pemasangan</td>
				<td style="width: 65%;">: {{$surat_izin[0]->alamat}}</td>
			</tr>
			<tr>
				<td style="width: 30%;">Jangka Waktu</td>
				<td style="width: 65%;">: {{$surat_izin[0]->tgl_pesan}} sampai dengan {{$tgl_penurunan}}</td>
			</tr>
		</table>
		<br>
		<table width="625">
			<tr>
				<td>
					KEDUA	:
				</td>
			</tr>
			<tr>
		       <td>
			       <ol>
					   <li>
						<font size="2">
							Atas pemberian izin sebagaimana dimaksud diktum KESATU dikenakan retribusi pajak sebesar Rp. {{($surat_izin[0]->lama_sewa * $surat_izin[0]->harga) * 0.25}}
						</font>
					   </li>
					   <li>
						<font size="2">
							Keputusan ini disampaikan kepada yang berkepentingan, dan berlaku sejak tanggal ditetapkan.
						</font>
					   </li>
				   </ol>
		       </td>
		    </tr>
		</table>
		<br>
		<table>
			<tr>
				<td width="430"><br><br><br><br></td>
				<td class="text" align="center">Kepala Dinas<br><br><br><br>Yohanis Wemben, SH, MH</td>
			</tr>
	     </table>
	</center>
</body>
</html>