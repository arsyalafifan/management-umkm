<?php
namespace App;

use Illuminate\Support\Facades\DB;

class globalFunction {
	public static function dateIndonesia($date) {
        try {
        	
            $result = substr($date, 8, 2) . " " . self::bulan(substr($date, 5, 2)) . " " . substr($date, 0, 4);

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function bulan($i) {
        $i = intval($i);
        $data = array(
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        return $data[$i - 1];
    }
	
	public static function getHariIndo($hari){
		if (substr(strtolower($hari),0,3)=="mon") return "Senin";
		else if (substr(strtolower($hari),0,3)=="tue") return "Selasa";
		else if (substr(strtolower($hari),0,3)=="wed") return "Rabu";
		else if (substr(strtolower($hari),0,3)=="thu") return "Kamis";
		else if (substr(strtolower($hari),0,3)=="fri") return "Jumat";
		else if (substr(strtolower($hari),0,3)=="sat") return "Sabtu";
		else if (substr(strtolower($hari),0,3)=="sun") return "Minggu";
	}
	
	public static function datePostgres($tanggal) {
        $result = null;
        $result = substr($tanggal, 6, 4) . '/' . substr($tanggal, 3, 2) . '/' . substr($tanggal, 0, 2);
        if ($result == "//") {
            return null;
        }
        return $result;
    }

	public static function bacaTerbilang($x, $style=4) {
		function kata($x) {
		    $x = abs($x);
		    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
		    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		    $temp = "";
		    if ($x <12) {
		        $temp = " ". $angka[$x];
		    } else if ($x <20) {
		        $temp = kata($x - 10). " belas";
		    } else if ($x <100) {
		        $temp = kata($x/10)." puluh". kata($x % 10);
		    } else if ($x <200) {
		        $temp = " seratus" . kata($x - 100);
		    } else if ($x <1000) {
		        $temp = kata($x/100) . " ratus" . kata($x % 100);
		    } else if ($x <2000) {
		        $temp = " seribu" . kata($x - 1000);
		    } else if ($x <1000000) {
		        $temp = kata($x/1000) . " ribu" . kata($x % 1000);
		    } else if ($x <1000000000) {
		        $temp = kata($x/1000000) . " juta" . kata($x % 1000000);
		    } else if ($x <1000000000000) {
		        $temp = kata($x/1000000000) . " milyar" . kata(fmod($x,1000000000));
		    } else if ($x <1000000000000000) {
		        $temp = kata($x/1000000000000) . " trilyun" . kata(fmod($x,1000000000000));
		    }      
		    return $temp;
		}
		
	    if($x<0) {
	        $hasil = "minus ". trim(kata($x));
	    }elseif($x===0) {
			$hasil="nol";
		}else {
	        $hasil = trim(kata($x));
	    }      
	    switch ($style) {
	        case 1:
	            $hasil = strtoupper($hasil);
	            break;
	        case 2:
	            $hasil = strtolower($hasil);
	            break;
	        case 3:
	            $hasil = ucwords($hasil);
	            break;
	        default:
	            $hasil = ucfirst($hasil);
	            break;
	    }    
	    return ($hasil==""?"":$hasil);
	}
		
    public static function bulanRomawi($i) {
        $i = intval($i);
        $data = array(
            'I', 'II', 'III', 'IV', 'V', 'VI',
            'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        );

        return $data[$i - 1];
    }
		
    public static function triwulanRomawi($i) {
        $i = intval($i);
        $data = array(
            'I', 'II', 'III', 'IV'
        );

        return $data[$i - 1];
    }

}
?>