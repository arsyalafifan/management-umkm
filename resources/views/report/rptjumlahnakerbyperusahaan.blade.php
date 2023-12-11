@include('report.asset')

@if($jenisreport == "pdf")
<style>
td{
    padding-left:5px;
    padding-right:5px;
    color:black;
    font-size:7px;
    height:11px;
    border: 3px solid black;
}
th{
    padding-left:5px;
    padding-right:5px;
    font-size:10px;
    vertical-align: middle;
    color:black;
}
</style>
@endif

@if($jenisreport == "pdf")
<div class="loading"></div>
<input type="button" onclick="generate()" value="Export To PDF" />
<table width="100%" cellpadding="0" cellspacing="0" id="table_header">
    <tr>
        <th width="20%" colspan="5">
            <img width="80" src="data:image/png;base64, {{$base64Logo}}"/>
        </th>
        <th style="text-align: center; vertical-align: middle;">
            <b>Daftar Perusahaan {{$jenisdaerah}} {{$kota}}</b><br>
            <b>Periode: {{$tglcetak}}</b>
        </th>
        <th width="20%">
            
        </th>
    </tr>
    <tr><th style="height: 22px;" colspan="5"></th></tr>
</table>
@endif

<table width="100%" cellpadding="0" cellspacing="0" id="simple_table">
    @if($jenisreport != "pdf")
    <tr>
        <th style="text-align: center; vertical-align: middle;" colspan=5">
            <img width="80" height="100" src="{{ $logoUrl }}">
            <b>Daftar Perusahaan {{$jenisdaerah}} {{$kota}}</b><br>
            <b>Periode: {{$tglcetak}}</b>
        </th>
    </tr>
    <tr><th style="height: 22px;" colspan="5"></th></tr>
    @endif

    <tbody>
    @php $no = 1; $prevkec=null; $prevkel=null; $sumkelurahan = 0; $sumkecamatan = 0; $prevkecnama=null;@endphp
    @if (!is_null($data))
        @foreach($data as $per)

            <!-- FOOTER KEL-->
            @if($prevkel != $per->kecamatanid.$per->kelurahanid)
                @if(!is_null($prevkel))
                    <tr>
                        <td style="border: 1px solid #000000;text-align: right;" colspan="4" class="h-right"><i>Total</i></td>
                        <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($sumkelurahan, 1) }}</td>
                    </tr>
                @endif
                @php 
                $sumkelurahan = 0;
                @endphp
            @endif

            <!-- FOOTER KEC-->
            @if($prevkec != $per->kecamatanid)
                @if(!is_null($prevkec))
                    <tr>
                        <td style="border: 1px solid #000000;text-align: right;" colspan="4" class="h-right"><i>Total {{ $prevkecnama }}</i></td>
                        <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($sumkecamatan, 1) }}</td>
                    </tr>
                @endif
                @php 
                $sumkecamatan = 0;
                @endphp
            @endif
                
            @if($prevkec != $per->kecamatanid)
            <tr>
                <td style="border: 1px solid #000000; font-weight: bold;" colspan="5"><b>Kecamatan: {{ $per->namakec }}</b></td>
            </tr>
            @endif

            @if($prevkel != $per->kecamatanid.$per->kelurahanid)
            <tr>
                <td style="border: 1px solid #000000;" colspan="5">Kelurahan: {{ $per->namakel }}</td>
            </tr>

            @if($jenisreport == "pdf")
            <tr>
                <td style="width:5%;text-align: center; border: 1px solid #000000;" rowspan="2" class="h-center"><b>No</b></td>
                <td style="width:50%;text-align: center; border: 1px solid #000000;" rowspan="2" class="h-center"><b>Perusahaan</b></td>
                <td style="width:30%;text-align: center; border: 1px solid #000000;" colspan="2" class="h-center"><b>Jenis Kelamin</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" rowspan="2" class="h-center"><b>Jumlah</b></td>
            </tr>
            <tr>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>L</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>P</b></td>
            </tr>
            @else
            <tr>
                <td style="width:8px;text-align: center; vertical-align: center; border: 1px solid #000000;" rowspan="2"><b>No</b></td>
                <td style="width:64px;text-align: center; vertical-align: center; border: 1px solid #000000;" rowspan="2"><b>Perusahaan</b></td>
                <td style="width:48px;text-align: center; vertical-align: center; border: 1px solid #000000;" colspan="2"><b>Jenis Kelamin</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;" rowspan="2"><b>Jumlah</b></td>
            </tr>
            <tr>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>L</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>P</b></td>
            </tr>
            @endif
            @endif

            <tr>
                <td style="border: 1px solid #000000;"></td>
                <td style="border: 1px solid #000000;">{{ $per->nama }}</td>
                <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($per->jumlahlaki, 1) }}</td>
                <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($per->jumlahperempuan, 1) }}</td>
                <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format(($per->jumlahlaki+$per->jumlahperempuan), 1) }}</td>
            </tr>

            @php 
                $prevkec=$per->kecamatanid;
                $prevkecnama=$per->namakec;
                $prevkel=$per->kecamatanid.$per->kelurahanid;
                $sumkelurahan += ($per->jumlahlaki+$per->jumlahperempuan);
                $sumkecamatan += ($per->jumlahlaki+$per->jumlahperempuan);
            @endphp
        @endforeach

        @if(!is_null($prevkel))
            <tr>
                <td style="border: 1px solid #000000;text-align: right;" colspan="4" class="h-right"><i>Total</i></td>
                <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($sumkelurahan, 1) }}</td>
            </tr>
        @endif

        @if(!is_null($prevkec))
            <tr>
                <td style="border: 1px solid #000000;text-align: right;" colspan="4" class="h-right"><i>Total {{ $prevkecnama }}</i></td>
                <td style="border: 1px solid #000000;text-align: center;" class="h-center">{{ number_format($sumkecamatan, 1) }}</td>
            </tr>
        @endif
    @endif
    </tbody>
</table>

<script type="text/javascript">
    function generate() {
        var doc = new jsPDF('l', 'pt', 'letter');

        doc.setLineWidth(2);

        doc.autoTable({
            html: '#table_header',
            startY: 10,
            theme: 'plain',
            styles: {
                minCellHeight: 1,
                halign: "center",
                fontSize: 8
            },
            didParseCell(data) {
                if (data.row.index === 0 || data.row.index === 1) {
                    data.cell.styles.halign = 'center';
                    data.cell.styles.fontStyle = 'bold';
                }

                //Logo
                if (data.row.index === 0 && data.column.index === 0) {
                    var td = data.cell.raw;
                    var img = td.getElementsByTagName('img')[0];
                    doc.addImage(img.src, 'JPEG', 40,  10, 80, 80);
                }
            }
        })

        doc.autoTable({
            html: '#simple_table',
            startY: doc.lastAutoTable.finalY + 60,
            theme: 'plain',
            columnStyles: {
                0: {
                    cellWidth: 30
                },
                2: {
                    cellWidth: 100
                },
                3: {
                    cellWidth: 100
                },
                4: {
                    cellWidth: 100
                }
            },
            styles: {
                minCellHeight: 10,
                fontSize: 6,
                lineColor: [0, 0, 0], lineWidth: 0.5,
            },
            didParseCell(data) {
                var td = data.cell.raw;
                if(td.firstElementChild !== null){
                    //Element B
                    if(td.firstElementChild.tagName=="B")
                    data.cell.styles.fontStyle = 'bold';
                    else if(td.firstElementChild.tagName=="I")
                    data.cell.styles.fontStyle = 'italic';
                }
                if(td.classList.contains("h-center")){
                    data.cell.styles.halign = 'center';
                }
                if(td.classList.contains("h-right")){
                    data.cell.styles.halign = 'right';
                }
            }
        })
        
        doc.save('rptjumlahnakerbyperusahaan_' + new Date() +'.pdf');
    }

    generate()
</script>

<script>
    setTimeout(() => {
        window.close();
    }, 500);
</script>