<!DOCTYPE html>
<head>
    <title>Surat Perizinan</title>
    <meta charset="utf-8">
    <style>
        #judul{
            text-align:center;
        }

        #halaman{
            width: auto; 
            height: auto; 
            position: absolute; 
            /* border: 1px solid;  */
            padding-top: 30px; 
            padding-left: 30px; 
            padding-right: 30px; 
            padding-bottom: 80px;
        }

    </style>

</head>

<body>
    <div id=halaman>
        <h3 id=judul>Pemerintah </h3>

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

        <table>
            <tr>
                <td style="width: 30%;">Nama Vendor</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{$vendor}}</td>
            </tr>
            <tr>
                <td style="width: 30%;">Ukuran Reklame</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{$surat_izin[0]->ukuran}}</td>
            </tr>
            <tr>
                <td style="width: 30%; vertical-align: top;">Alamat Pemasangan</td>
                <td style="width: 5%; vertical-align: top;">:</td>
                <td style="width: 65%;">{{$surat_izin[0]->alamat}}</td>
            </tr>
            <tr>
                <td style="width: 30%;">Nama Penyewa</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{$penyewa}}</td>
            </tr>
        </table>

        <p>vendor diatas telah diizinkan oleh Dinas Modal dan Pelayanan Terpadu Satu Pintu Kota Jayapura.</p>

        {{-- <div style="width: 50%; text-align: left; float: right;">Jayapura, 20 Januari 2020</div><br>
        <div style="width: 50%; text-align: left; float: right;">Yang bertanda tangan,</div><br><br><br><br><br>
        <div style="width: 50%; text-align: left; float: right;">Arbrian Abdul Jamal</div> --}}

    </div>
</body>

</html>