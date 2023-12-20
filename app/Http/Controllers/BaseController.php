<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function kata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = $this->kata($x - 10). " belas";
        } else if ($x <100) {
            $temp = $this->kata($x/10)." puluh". $this->kata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . $this->kata($x - 100);
        } else if ($x <1000) {
            $temp = $this->kata($x/100) . " ratus" . $this->kata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . $this->kata($x - 1000);
        } else if ($x <1000000) {
            $temp = $this->kata($x/1000) . " ribu" . $this->kata($x % 1000);
        } else if ($x <1000000000) {
            $temp = $this->kata($x/1000000) . " juta" . $this->kata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = $this->kata($x/1000000000) . " milyar" . $this->kata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = kata($x/1000000000000) . " trilyun" . kata(fmod($x,1000000000000));
        }      
        return $temp;
    }

    public function bacaTerbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim($this->kata($x));
        }elseif($x===0) {
            $hasil="nol";
        }else {
            $hasil = trim($this->kata($x));
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
        return ($hasil==""?"":$hasil." Rupiah");
    }
}