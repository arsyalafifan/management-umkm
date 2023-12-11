function getUrlAjax(controllername, urltype, routename, urlapi){
	//return 'http://localhost/kapitasi/servicepenatausahaan/public/index.php/api/'+routename;
	return controllername;
}

function getHeaderAjax (xhr) {
    //xhr.setRequestHeader('Authorization', 'Bearer 25|bfVcV6dOMh7myiVRlOwjPKOuf1huFTlcTC8OCMWJ');
}

function getNamaBulan(bulan){
	var strBulan = '';
	if (parseInt(bulan) == 1){
		strBulan = 'Januari';
	}else if (parseInt(bulan) == 2){
		strBulan = 'Februari';
	}else if (parseInt(bulan) == 3){
		strBulan = 'Maret';
	}else if (parseInt(bulan) == 4){
		strBulan = 'April';
	}else if (parseInt(bulan) == 5){
		strBulan = 'Mei';
	}else if (parseInt(bulan) == 6){
		strBulan = 'Juni';
	}else if (parseInt(bulan) == 7){
		strBulan = 'Juli';
	}else if (parseInt(bulan) == 8){
		strBulan = 'Agustus';
	}else if (parseInt(bulan) == 9){
		strBulan = 'September';
	}else if (parseInt(bulan) == 10){
		strBulan = 'Oktober';
	}else if (parseInt(bulan) == 11){
		strBulan = 'November';
	}else if (parseInt(bulan) == 12){
		strBulan = 'Desember';
	}
	return strBulan;
}
function DateFormat(tanggal){
	if (tanggal === null||tanggal === undefined||tanggal === '') return '';
	arTanggal = tanggal.split('-');
	
	return parseInt(arTanggal[2])+" "+getNamaBulan(arTanggal[1])+" "+arTanggal[0];
}

function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function parseStr(v) {
  	return v + '';
}

function MoneyFormat(v,maxDesimal,isShowNegatif){
  	if (v==null) return '0';
	if (maxDesimal==null) maxDesimal = 2;
	if (isShowNegatif==null) isShowNegatif = false;
	v = parseStr(roundNumber(v,maxDesimal));
	var isNegatif = false;
	if (v.substr(0,1)=='-'){
		isNegatif = true;
		v = v.replace('-','');
	}
	var arrNilai = v.split('.');
	var hasil = '';
	var ind=0;
	for (i=arrNilai[0].length-1; i>=0; i--){
		ind++;
		hasil = arrNilai[0].substr(i,1)+hasil;
		if (i!=0 && ind%3==0) hasil = ',' + hasil;
	}
	var desimal=(arrNilai.length>1 ? arrNilai[1] : '');
	while ((desimal.length)<maxDesimal){
		desimal += '0';
	}
	hasil += '.'+desimal;
	return (isShowNegatif && isNegatif ? '-' : '')+ hasil;
}

function reverseFormatNumber(val,locale){
    var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
    var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, '');
    var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
    reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
    return Number.isNaN(reversedVal)?0:reversedVal;
}

function validateNumber(evt) {
    var theEvent = evt || window.event;
    if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
    } else {
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
    }
    var regex = /[0-9]/;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

function validateFloat(evt) {
    var theEvent = evt || window.event;
    if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
    } else {
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
    }
    var regex = /^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/;
    if( !regex.test(key) ) {
	alert('not valid');
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

const rupiah = (number)=>{
	return new Intl.NumberFormat("id-ID", {
	style: "currency",
	currency: "IDR"
	}).format(number);
}

// format rupiah ketika input
function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

/**
 merubah format tanggal menjadi bilangan:
 e.g : DateFormat('17-12-2012')
 result : 17 Desember 2012
 **/
 function DateFormat(tanggal) {
    if (tanggal === null)
        return '';
    arTanggal = tanggal.split('-');
    var strBulan = '';
    if (arTanggal[1] == '01') {
        strBulan = 'Januari';
    } else if (arTanggal[1] == '02') {
        strBulan = 'Februari';
    } else if (arTanggal[1] == '03') {
        strBulan = 'Maret';
    } else if (arTanggal[1] == '04') {
        strBulan = 'April';
    } else if (arTanggal[1] == '05') {
        strBulan = 'Mei';
    } else if (arTanggal[1] == '06') {
        strBulan = 'Juni';
    } else if (arTanggal[1] == '07') {
        strBulan = 'Juli';
    } else if (arTanggal[1] == '08') {
        strBulan = 'Agustus';
    } else if (arTanggal[1] == '09') {
        strBulan = 'September';
    } else if (arTanggal[1] == '10') {
        strBulan = 'Oktober';
    } else if (arTanggal[1] == '11') {
        strBulan = 'November';
    } else if (arTanggal[1] == '12') {
        strBulan = 'Desember';
    }
    return arTanggal[2] + ' ' + strBulan + ' ' + arTanggal[0];
}

// postgresql date format (yyyy-mm-dd) to dd/mm/yyyy
function indonesianFormatDate (input) {
	var datePart = input.match(/\d+/g),
	year = datePart[0].substring(2), // get only two digits
	month = datePart[1], day = datePart[2];

	return day+'/'+month+'/'+year;
}

/** 
 * mengubah angka bilangan menjadi terbilang rupiah 
 * contoh: 50000 menjadi lima puluh ribu rupiah
 * **/
function terbilang(bilangan) {

	bilangan    = String(bilangan);
	let angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
	let kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
	let tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

	let panjang_bilangan = bilangan.length;
	let kalimat= subkalimat = kata1 = kata2 = kata3 = "";
	let i= j= 0;

	/* pengujian panjang bilangan */
		if (panjang_bilangan > 15) {
			kalimat = "Diluar Batas";
			return kalimat;
		}

		/* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
		for (i = 1; i <= panjang_bilangan; i++) {
			angka[i] = bilangan.substr(-(i),1);
		}

		i = 1;
		j = 0;
		kalimat = "";

		/* mulai proses iterasi terhadap array angka */
		while (i <= panjang_bilangan) {

			subkalimat = "";
			kata1 = "";
			kata2 = "";
			kata3 = "";

			/* untuk Ratusan */
			if (angka[i+2] != "0") {
				if (angka[i+2] == "1") {
				kata1 = "Seratus";
				} else {
				kata1 = kata[angka[i+2]] + " Ratus";
				}
			}

			/* untuk Puluhan atau Belasan */
			if (angka[i+1] != "0") {
				if (angka[i+1] == "1") {
				if (angka[i] == "0") {
					kata2 = "Sepuluh";
				} else if (angka[i] == "1") {
					kata2 = "Sebelas";
				} else {
					kata2 = kata[angka[i]] + " Belas";
				}
				} else {
				kata2 = kata[angka[i+1]] + " Puluh";
				}
			}

			/* untuk Satuan */
			if (angka[i] != "0") {
				if (angka[i+1] != "1") {
				kata3 = kata[angka[i]];
				}
			}

			/* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
			if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
				subkalimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
			}

			/* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
			kalimat = subkalimat + kalimat;
			i = i + 3;
			j = j + 1;

		}

		/* mengganti Satu Ribu jadi Seribu jika diperlukan */
		if ((angka[5] == "0") && (angka[6] == "0")) {
			kalimat = kalimat.replace("Satu Ribu","Seribu");
		}

	return (kalimat.trim().replace(/\s{2,}/g, ' ')) + " Rupiah";
}