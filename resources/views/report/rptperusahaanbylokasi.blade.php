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
        <th width="20%" colspan="6">
            <img width="80" src="data:image/png;base64, {{$base64Logo}}"/>
        </th>
        <th style="text-align: center; vertical-align: middle;">
            <b>Daftar Perusahaan {{$jenisdaerah}} {{$kota}}</b><br>
            <b>Periode: {{$tglcetak}}</b>
        </th>
        <th width="20%">
            
        </th>
    </tr>
    <tr><th style="height: 22px;" colspan="6"></th></tr>
</table>
@endif

<table width="100%" cellpadding="0" cellspacing="0" id="simple_table">
    @if($jenisreport != "pdf")
    <tr>
        <th style="text-align: center; vertical-align: middle;" colspan="6">
            <img width="80" height="100" src="{{ $logoUrl }}">
            <b>Daftar Perusahaan {{$jenisdaerah}} {{$kota}}</b><br>
            <b>Periode: {{$tglcetak}}</b>
        </th>
    </tr>
    <tr><th style="height: 22px;" colspan="6"></th></tr>
    @endif

    <tbody>
    @php $no = 1; $prevkec=null; $prevkel=null; @endphp
    @if (!is_null($data))
        @foreach($data as $per)
            @if($prevkec != $per->kecamatanid)
            <tr>
                <td style="border: 1px solid #000000; font-weight: bold;" colspan="6"><b>Kecamatan: {{ $per->namakec }}</b></td>
            </tr>
            @endif

            @if($prevkel != $per->kecamatanid.$per->kelurahanid)
            <tr>
                <td style="border: 1px solid #000000;" colspan="6">Kelurahan: {{ $per->namakel }}</td>
            </tr>

            @if($jenisreport == "pdf")
            <tr>
                <td style="width:5%;text-align: center; border: 1px solid #000000;" class="h-center"><b>No</b></td>
                <td style="width:35%;text-align: center; border: 1px solid #000000;" class="h-center"><b>Perusahaan</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>Kawasan Industri</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>Kecamatan</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>Kelurahan</b></td>
                <td style="width:15%;text-align: center; border: 1px solid #000000;" class="h-center"><b>NIB</b></td>
            </tr>
            @else
            <tr>
                <td style="width:8px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>No</b></td>
                <td style="width:40px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>Perusahaan</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>Kawasan Industri</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>Kecamatan</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>Kelurahan</b></td>
                <td style="width:24px;text-align: center; vertical-align: center; border: 1px solid #000000;"><b>NIB</b></td>
            </tr>
            @endif
            @endif

            <tr>
                <td style="border: 1px solid #000000;"></td>
                <td style="border: 1px solid #000000;">{{ $per->nama }}</td>
                <td style="border: 1px solid #000000;">{{ $per->namainstansi }}</td>
                <td style="border: 1px solid #000000;">{{ $per->namakec }}</td>
                <td style="border: 1px solid #000000;">{{ $per->namakel }}</td>
                <td style="border: 1px solid #000000;">{{ $per->nib }}</td>
            </tr>

            @php 
                $prevkec=$per->kecamatanid;
                $prevkel=$per->kecamatanid.$per->kelurahanid;
            @endphp
        @endforeach
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
                },
                5: {
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
                }
                if(td.classList.contains("h-center")){
                    data.cell.styles.halign = 'center';
                }
            }
        })
        
        doc.save('rptperusahaanbylokasi_' + new Date() +'.pdf');
    }

    generate()
</script>

<script>
    setTimeout(() => {
        window.close();
    }, 500);
</script>