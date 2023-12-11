<?php
namespace App;
class apptemplate {
    public static function gettemplate($mode, $key) {
        $result = '';
        if ($mode == 'sip') {
            switch ($key) {
                case 'app_alias1':
                    $result = '';
                    break;
                case 'app_alias2':
                    $result = 'E-Database Ketenagakerjaan';
                    break;
                case 'index_theme':
                    $result = 'skin-index-blue';
                    break;
                case 'main_theme':
                    $result = 'skin-blue';
                    break;
                case 'logo':
                    $result = 'logo-sip.png';
                    break;
                case 'comp_name':
                    $result = 'Riqcom Services';
                    break;
                case 'comp_alias':
                    $result = 'Riqcom';
                    break;
                case 'comp_address':
                    $result = 'Townhouse Mediterania Asri Blok FF2 No. 2';
                    break;
                case 'comp_city':
                    $result = 'Batam';
                    break;
                case 'comp_country':
                    $result = 'Indonesia';
                    break;
                case 'comp_postal_code':
                    $result = '29432';
                    break;
                case 'comp_email':
                    $result = 'admin@riqcom.co.id';
                    break;
                case 'comp_email_helpdesk':
                    $result = 'admin@riqcom.co.id';
                    break;
                case 'comp_telp_all':
                    $result = '0811-700-0000';
                    break;
                case 'comp_telp':
                    $result = '0811-700-0000';
                    break;
                case 'comp_fax_all':
                    $result = '-';
                    break;
                case 'comp_fax':
                    $result = '-';
                    break;
                case 'favicon':
                    $result = 'favicon-sip.png';
                    break;
                case 'logo-32':
                    $result = 'logo-32-sip.png';
                    break;
                case 'logo-64':
                    $result = 'logo-64-sip.png';
                    break;
                case 'logo_index':
                    $result = 'logo-index-sip.png';
                    break;
                case 'logo_index_inverse':
                    $result = 'logo-index-inverse-sip.png';
                    break;
                case 'logo_index2':
                    $result = 'logo-index-sip.png';
                    break;
                case 'index_bg':
                    $result = 'bg-index-sip.png';
                    break;
                case 'index_nav_bgcolor':
                    $result = '#587792';
                    break;
                
            }
        }
        else {
            switch ($key) {
                case 'app_alias1':
                    $result = '';
                    break;
                case 'app_alias2':
                    $result = 'E-Database Ketenagakerjaan';
                    break;
                case 'index_theme':
                    $result = 'skin-index-maroon';
                    break;
                case 'main_theme':
                    $result = 'skin-maroon';
                    break;
                case 'logo':
                    $result = 'logo-sipd.png';
                    break;
                case 'comp_name':
                    $result = 'Dinas Pendidikan Kepri';
                    break;
                case 'comp_alias':
                    $result = 'Disdik Kepri';
                    break;
                case 'comp_address':
                    $result = 'Jl. Medan Merdeka Utara No. 7';
                    break;
                case 'comp_city':
                    $result = 'Jakarta';
                    break;
                case 'comp_country':
                    $result = 'Indonesia';
                    break;
                case 'comp_postal_code':
                    $result = '10110';
                    break;
                case 'comp_email_helpdesk':
                    $result = 'pengaduan@kemendagri.go.id';
                    break;
                case 'comp_telp_all':
                    $result = '(021) 3450038';
                    break;
                case 'comp_telp':
                    $result = '0213450038';
                    break;
                case 'comp_fax_all':
                    $result = '(021) 3851193, 34830261, 3846430';
                    break;
                case 'comp_fax':
                    $result = '0213851193';
                    break;
                case 'favicon':
                    $result = 'favicon-sipd.png';
                    break;
                case 'logo-32':
                    $result = 'logo-32-sipd.png';
                    break;
                case 'logo-64':
                    $result = 'logo-64-sipd.png';
                    break;
                case 'logo_index':
                    $result = 'logo-index-sipd.png';
                    break;
                case 'logo_index_inverse':
                    $result = 'logo-index-inverse-sipd.png';
                    break;
                case 'logo_index-2':
                    $result = 'logo-index-sipd.png';
                    break;
                case 'index_bg':
                    $result = 'bg-index-sipd.png';
                    break;
                case 'index_nav_bgcolor':
                    $result = '#1b1b1b';
                    break;
                
            }
        }

        return $result;
    }

}
?>