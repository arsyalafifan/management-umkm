<?php
namespace App;

use Illuminate\Support\Arr;

class enumVar {
    const USER_SUPERADMIN = 1;
    const USER_ADMIN_DISDIK = 2;
    const USER_SEKOLAH = 3;
    const USER_PERUSAHAAN = 4;
    const USER_DESC_SUPERADMIN = "Superadmin";
    const USER_DESC_ADMIN_DISDIK = "Admin Disdik";
    const USER_DESC_SEKOLAH = "Sekolah";
    const USER_DESC_PERUSAHAAN = "Perusahaan";
    // const USER_NAKER = 3;
    // const USER_EKSEKUTIF = 4;
    // const USER_AUDITOR = 5;

    const JENISKOTA_KABUPATEN = 1;
    const JENISKOTA_KOTA = 2;   

    const BIDANG_PERTANIAN = 0;
    const BIDANG_PRODUKSI_BAHAN_MENTAH = 1;
    const BIDANG_MANUFAKTUR = 2;
    const BIDANG_KONSTRUKSI = 3;
    const BIDANG_TRANSPORTASI = 4;
    const BIDANG_KOMUNIKASI = 5;
    const BIDANG_PERDAGANGAN_BESAR_KECIL = 6;
    const BIDANG_FINANSIAL = 7;
    const BIDANG_JASA = 8;

    const BADANUSAHA_PERUSAHAAN_PERSEORANGAN = 0;
    const BADANUSAHA_FIRMA = 1;
    const BADANUSAHA_CV = 2;
    const BADANUSAHA_PT = 3;
    const BADANUSAHA_PERSERO = 4;
    const BADANUSAHA_BUMD = 5;
    const BADANUSAHA_BUMN = 6;
    const BADANUSAHA_KOPERASI = 7;
    const BADANUSAHA_YAYASAN = 8;
    const BADANUSAHA_LAINNYA = 9;

    const BADANUSAHA_DESC_PERUSAHAAN_PERSEORANGAN = "Perusahaan Perseorangan";
    const BADANUSAHA_DESC_FIRMA = "Firma";
    const BADANUSAHA_DESC_CV = "CV";
    const BADANUSAHA_DESC_PT = "PT";
    const BADANUSAHA_DESC_PERSERO = "Persero";
    const BADANUSAHA_DESC_BUMD = "BUMD";
    const BADANUSAHA_DESC_BUMN = "BUMN";
    const BADANUSAHA_DESC_KOPERASI = "Koperasi";
    const BADANUSAHA_DESC_YAYASAN = "Yayasan";
    const BADANUSAHA_DESC_LAINNYA = "Lainnya";
    public function listBadanUsaha($name="id") {
        if ($name=="id")
            return array(self::BADANUSAHA_PERUSAHAAN_PERSEORANGAN, self::BADANUSAHA_FIRMA, self::BADANUSAHA_CV, self::BADANUSAHA_PT, self::BADANUSAHA_PERSERO, self::BADANUSAHA_BUMD, self::BADANUSAHA_BUMN, self::BADANUSAHA_KOPERASI, self::BADANUSAHA_YAYASAN, self::BADANUSAHA_LAINNYA);
        else
            return array(self::BADANUSAHA_DESC_PERUSAHAAN_PERSEORANGAN, self::BADANUSAHA_DESC_FIRMA, self::BADANUSAHA_DESC_CV, self::BADANUSAHA_DESC_PT, self::BADANUSAHA_DESC_PERSERO, self::BADANUSAHA_DESC_BUMD, self::BADANUSAHA_DESC_BUMN, self::BADANUSAHA_DESC_KOPERASI, self::BADANUSAHA_DESC_YAYASAN, self::BADANUSAHA_DESC_LAINNYA);
    }
    const STATUS_BADANUSAHA_PUSAT = 0;
    const STATUS_BADANUSAHA_CABANG = 1;

    const JENISMENU_MASTER = 1;
    const JENISMENU_SARPRAS = 2;
    const JENISMENU_UTILITAS = 4;
    const JENISMENU_VERIFIKASI = 3;
    const JENISMENU_LAPORAN = 5;

    const JENISMENUNAMA_MASTER = 'Master';
    const JENISMENUNAMA_SARPRAS = 'Sarpras';
    const JENISMENUNAMA_UTILITAS = 'Utilitas';
    const JENISMENUNAMA_VERIFIKASI = 'Verifikasi';
    const JENISMENUNAMA_LAPORAN = 'Laporan & Rekap';

    const JABATAN_STAFF = 0;
    const JABATAN_BENDAHARA = 1;
    const JABATAN_KEPALA_SEKSI = 2;
    const JABATAN_KEPALA_BIDANG = 3;
    const JABATAN_KEPALA_BADAN = 4;

    const JABATAN_DESC_STAFF = 'Staff';
    const JABATAN_DESC_BENDAHARA = 'Bendahara';
    const JABATAN_DESC_KEPALA_SEKSI = 'Kepala Seksi';
    const JABATAN_DESC_KEPALA_BIDANG = 'Kepala Bidang';
    const JABATAN_DESC_KEPALA_BADAN = 'Kepala Badan/Dinas';
    public function listJabatan($name="id") {
        if ($name=="id")
            return array(self::JABATAN_STAFF, self::JABATAN_BENDAHARA, self::JABATAN_KEPALA_SEKSI, self::JABATAN_KEPALA_BIDANG, self::JABATAN_KEPALA_BADAN);
        else
            return array(self::JABATAN_DESC_STAFF, self::JABATAN_DESC_BENDAHARA, self::JABATAN_DESC_KEPALA_SEKSI, self::JABATAN_DESC_KEPALA_BIDANG, self::JABATAN_DESC_KEPALA_BADAN);
    }
    const JENISNIK_KTP = 0;
    const JENISNIK_KITAS = 1;

    const JENISNIK_DESC_KTP = "KTP";
    const JENISNIK_DESC_KITAS = "KITAS";
    public function listJenisNik($name="id") {
        if ($name=="id")
            return array(self::JENISNIK_KTP, self::JENISNIK_KITAS);
        else
            return array(self::JENISNIK_DESC_KTP, self::JENISNIK_DESC_KITAS);
    }
    const JENISKELAMIN_LAKILAKI = 0;
    const JENISKELAMIN_PEREMPUAN = 1;

    const JENISKELAMIN_DESC_LAKILAKI = "Laki-Laki";
    const JENISKELAMIN_DESC_PEREMPUAN = "Perempuan";
    public function listJenisKelamin($name="id") {
        if ($name=="id")
            return array(self::JENISKELAMIN_LAKILAKI, self::JENISKELAMIN_PEREMPUAN);
        else
            return array(self::JENISKELAMIN_DESC_LAKILAKI, self::JENISKELAMIN_DESC_PEREMPUAN);
    }
    const AGAMA_BUDDHA = 0;
    const AGAMA_HINDU = 1;
    const AGAMA_ISLAM = 2;
    const AGAMA_KATOLIK = 3;
    const AGAMA_KONGHUCHU = 4;
    const AGAMA_PROTESTAN = 5;

    const AGAMA_DESC_BUDDHA = "Buddha";
    const AGAMA_DESC_HINDU = "Hindu";
    const AGAMA_DESC_ISLAM = "Islam";
    const AGAMA_DESC_KATOLIK = "Katolik";
    const AGAMA_DESC_KONGHUCHU = "Konghuchu";
    const AGAMA_DESC_PROTESTAN = "Protestan";
    public function listAgama($name="id") {
        if ($name=="id")
            return array(self::AGAMA_BUDDHA, self::AGAMA_HINDU, self::AGAMA_ISLAM, self::AGAMA_KATOLIK, self::AGAMA_KONGHUCHU, self::AGAMA_PROTESTAN);
        else
            return array(self::AGAMA_DESC_BUDDHA, self::AGAMA_DESC_HINDU, self::AGAMA_DESC_ISLAM, self::AGAMA_DESC_KATOLIK, self::AGAMA_DESC_KONGHUCHU, self::AGAMA_DESC_PROTESTAN);
    }
    const STATUS_NIKAH_BELUM_KAWIN = 0;
    const STATUS_NIKAH_KAWIN = 1;
    const STATUS_NIKAH_CERAI_HIDUP = 2;
    const STATUS_NIKAH_CERAI_MATI = 3;

    const STATUS_NIKAH_DESC_BELUM_KAWIN = "Belum Kawin";
    const STATUS_NIKAH_DESC_KAWIN = "Kawin";
    const STATUS_NIKAH_DESC_CERAI_HIDUP = "Cerai Hidup";
    const STATUS_NIKAH_DESC_CERAI_MATI = "Cerai Mati";
    public function listStatusNikah($name="id") {
        if ($name=="id")
            return array(self::STATUS_NIKAH_BELUM_KAWIN, self::STATUS_NIKAH_KAWIN, self::STATUS_NIKAH_CERAI_HIDUP, self::STATUS_NIKAH_CERAI_MATI);
        else
            return array(self::STATUS_NIKAH_DESC_BELUM_KAWIN, self::STATUS_NIKAH_DESC_KAWIN, self::STATUS_NIKAH_DESC_CERAI_HIDUP, self::STATUS_NIKAH_DESC_CERAI_MATI);
    }
    const STATUS_PEKERJAAN_FULL_TIME = 0;
    const STATUS_PEKERJAAN_PART_TIME = 1;
    const STATUS_PEKERJAAN_WIRAUSAHA = 2;
    const STATUS_PEKERJAAN_PEKERJA_LEPAS = 3;
    const STATUS_PEKERJAAN_MAGANG = 4;
    const STATUS_PEKERJAAN_DESC_FULL_TIME = "Karyawan (full time)";
    const STATUS_PEKERJAAN_DESC_PART_TIME = "Karyawan paruh waktu (part time)";
    const STATUS_PEKERJAAN_DESC_WIRAUSAHA = "Wirausaha";
    const STATUS_PEKERJAAN_DESC_PEKERJA_LEPAS = "Pekerja Lepas";
    const STATUS_PEKERJAAN_DESC_MAGANG = "Magang (intern)";
    public function listStatusPekerjaan($name="id") {
        if ($name=="id")
            return array(self::STATUS_PEKERJAAN_FULL_TIME, self::STATUS_PEKERJAAN_PART_TIME, self::STATUS_PEKERJAAN_WIRAUSAHA, self::STATUS_PEKERJAAN_PEKERJA_LEPAS, self::STATUS_PEKERJAAN_MAGANG);
        else
            return array(self::STATUS_PEKERJAAN_DESC_FULL_TIME, self::STATUS_PEKERJAAN_DESC_PART_TIME, self::STATUS_PEKERJAAN_DESC_WIRAUSAHA, self::STATUS_PEKERJAAN_DESC_PEKERJA_LEPAS, self::STATUS_PEKERJAAN_DESC_MAGANG);
    }
    public static function getStatusPekerjaan($status) {
        if(is_null($status)) return null;
        else if($status==self::STATUS_PEKERJAAN_FULL_TIME) return self::STATUS_PEKERJAAN_DESC_FULL_TIME;
        else if($status==self::STATUS_PEKERJAAN_PART_TIME) return self::STATUS_PEKERJAAN_DESC_PART_TIME;
        else if($status==self::STATUS_PEKERJAAN_WIRAUSAHA) return self::STATUS_PEKERJAAN_DESC_WIRAUSAHA;
        else if($status==self::STATUS_PEKERJAAN_PEKERJA_LEPAS) return self::STATUS_PEKERJAAN_DESC_PEKERJA_LEPAS;
        else if($status==self::STATUS_PEKERJAAN_MAGANG) return self::STATUS_PEKERJAAN_DESC_MAGANG;
        else return "";
    }
    const LEVEL_NON_STAFF = 0;
    const LEVEL_SENIOR_NON_STAFF = 1;
    const LEVEL_STAFF = 2;
    const LEVEL_SENIOR_STAFF = 3;
    const LEVEL_SUPERVISOR = 4;
    const LEVEL_MANAGER = 5;
    const LEVEL_GENERAL_MANAGER = 6;
    const LEVEL_DIRECTOR = 7;
    const LEVEL_DESC_NON_STAFF = "Karyawan Non Staff";
    const LEVEL_DESC_SENIOR_NON_STAFF = "Karyawan Senior Non Staff";
    const LEVEL_DESC_STAFF = "Karyawan Staff";
    const LEVEL_DESC_SENIOR_STAFF = "Karyawan Senior Staff";
    const LEVEL_DESC_SUPERVISOR = "Supervisor";
    const LEVEL_DESC_MANAGER = "Manager";
    const LEVEL_DESC_GENERAL_MANAGER = "General Manager";
    const LEVEL_DESC_DIRECTOR = "Director";
    public function listLevel($name="id") {
        if ($name=="id")
            return array(self::LEVEL_NON_STAFF, self::LEVEL_SENIOR_NON_STAFF, self::LEVEL_STAFF, self::LEVEL_SENIOR_STAFF, self::LEVEL_SUPERVISOR, self::LEVEL_MANAGER, self::LEVEL_GENERAL_MANAGER, self::LEVEL_DIRECTOR);
        else
            return array(self::LEVEL_DESC_NON_STAFF, self::LEVEL_DESC_SENIOR_NON_STAFF, self::LEVEL_DESC_STAFF, self::LEVEL_DESC_SENIOR_STAFF, self::LEVEL_DESC_SUPERVISOR, self::LEVEL_DESC_MANAGER, self::LEVEL_DESC_GENERAL_MANAGER, self::LEVEL_DESC_DIRECTOR);
    }
    public static function getLevel($level) {
        if(is_null($level)) return null;
        else if($level==self::LEVEL_NON_STAFF) return self::LEVEL_DESC_NON_STAFF;
        else if($level==self::LEVEL_SENIOR_NON_STAFF) return self::LEVEL_DESC_SENIOR_NON_STAFF;
        else if($level==self::LEVEL_STAFF) return self::LEVEL_DESC_STAFF;
        else if($level==self::LEVEL_SENIOR_STAFF) return self::LEVEL_DESC_SENIOR_STAFF;
        else if($level==self::LEVEL_SUPERVISOR) return self::LEVEL_DESC_SUPERVISOR;
        else if($level==self::LEVEL_MANAGER) return self::LEVEL_DESC_MANAGER;
        else if($level==self::LEVEL_GENERAL_MANAGER) return self::LEVEL_DESC_GENERAL_MANAGER;
        else if($level==self::LEVEL_DIRECTOR) return self::LEVEL_DESC_DIRECTOR;
        else return "";
    }

    const BULAN_JAN = 1;
    const BULAN_FEB = 2;
    const BULAN_MAR = 3;
    const BULAN_APR = 4;
    const BULAN_MEI = 5;
    const BULAN_JUN = 6;
    const BULAN_JUL = 7;
    const BULAN_AGU = 8;
    const BULAN_SEP = 9;
    const BULAN_OKT = 10;
    const BULAN_NOV = 11;
    const BULAN_DES = 12;

    const BULAN_DESC_JAN = "Januari";
    const BULAN_DESC_FEB = "Februari";
    const BULAN_DESC_MAR = "Maret";
    const BULAN_DESC_APR = "April";
    const BULAN_DESC_MEI = "Mei";
    const BULAN_DESC_JUN = "Juni";
    const BULAN_DESC_JUL = "Juli";
    const BULAN_DESC_AGU = "Agustus";
    const BULAN_DESC_SEP = "September";
    const BULAN_DESC_OKT = "Oktober";
    const BULAN_DESC_NOV = "November";
    const BULAN_DESC_DES = "Desember";
    public function listBulan($name="id") {
        if ($name=="id")
            return array(self::BULAN_JAN, self::BULAN_FEB, self::BULAN_MAR, self::BULAN_APR, self::BULAN_MEI, self::BULAN_JUN, self::BULAN_JUL, self::BULAN_AGU, self::BULAN_SEP, self::BULAN_OKT, self::BULAN_NOV, self::BULAN_DES);
        else
            return array(self::BULAN_DESC_JAN, self::BULAN_DESC_FEB, self::BULAN_DESC_MAR, self::BULAN_DESC_APR, self::BULAN_DESC_MEI, self::BULAN_DESC_JUN, self::BULAN_DESC_JUL, self::BULAN_DESC_AGU, self::BULAN_DESC_SEP, self::BULAN_DESC_OKT, self::BULAN_DESC_NOV, self::BULAN_DESC_DES);
    }

    const TAHUN_2011 = 1;
    const TAHUN_2012 = 2;
    const TAHUN_2013 = 3;
    const TAHUN_2014 = 4;
    const TAHUN_2015 = 5;
    const TAHUN_2016 = 6;
    const TAHUN_2017 = 7;
    const TAHUN_2018 = 8;
    const TAHUN_2019 = 9;
    const TAHUN_2020 = 10;
    const TAHUN_2021 = 11;
    const TAHUN_2022 = 12;
    const TAHUN_2023 = 13;

    const TAHUN_DESC_2011 = '2011';
    const TAHUN_DESC_2012 = '2012';
    const TAHUN_DESC_2013 = '2013';
    const TAHUN_DESC_2014 = '2014';
    const TAHUN_DESC_2015 = '2015';
    const TAHUN_DESC_2016 = '2016';
    const TAHUN_DESC_2017 = '2017';
    const TAHUN_DESC_2018 = '2018';
    const TAHUN_DESC_2019 = '2019';
    const TAHUN_DESC_2020 = '2020';
    const TAHUN_DESC_2021 = '2021';
    const TAHUN_DESC_2022 = '2022';
    const TAHUN_DESC_2023 = '2023';
    
    public function listTahun() {
        return array(
            self::TAHUN_DESC_2011, 
            self::TAHUN_DESC_2012, 
            self::TAHUN_DESC_2013, 
            self::TAHUN_DESC_2014, 
            self::TAHUN_DESC_2015, 
            self::TAHUN_DESC_2016, 
            self::TAHUN_DESC_2017, 
            self::TAHUN_DESC_2018, 
            self::TAHUN_DESC_2019, 
            self::TAHUN_DESC_2020, 
            self::TAHUN_DESC_2021, 
            self::TAHUN_DESC_2022, 
            self::TAHUN_DESC_2023
        );
    }

    const JENJANG_SMA = 1;
    const JENJANG_SMK = 2;
    const JENJANG_SLB = 3;
    const JENJANG_DESC_SMA = "SMA";
    const JENJANG_DESC_SMK = "SMK";
    const JENJANG_DESC_SLB = "SLB";

    public function listJenjang($name="id") {
        if ($name=="id")
            return array(self::JENJANG_SMA, self::JENJANG_SMK, self::JENJANG_SLB);
        else
            return array(self::JENJANG_DESC_SMA, self::JENJANG_DESC_SMK, self::JENJANG_DESC_SLB);
    }

    const JENIS_NEGERI = 1;
    const JENIS_SWASTA = 2;
    const JENIS_DESC_NEGERI = "Negeri";
    const JENIS_DESC_SWASTA = "Swasta";

    public function listJenisSekolah($name="id") {
        if ($name=="id")
            return array(self::JENIS_NEGERI, self::JENIS_SWASTA);
        else
            return array(self::JENIS_DESC_NEGERI, self::JENIS_DESC_SWASTA);
    }

    const KURIKULUM_13 = 1;
    const KURIKULUM_MERDEKA = 2;
    const KURIKULUM_DESC_13 = "Kurikulum 13";
    const KURIKULUM_DESC_MERDEKA = "Kurikulum Merdeka";

    public function listKurikulum($name="id") {
        if ($name=="id")
            return array(self::KURIKULUM_13, self::KURIKULUM_MERDEKA);
        else
            return array(self::KURIKULUM_DESC_13, self::KURIKULUM_DESC_MERDEKA);
    }

    const SEKOLAH_PENGGERAK = 1;
    const SEKOLAH_ADIWIYATA = 2;
    const SEKOLAH_RAMAH_ANAK = 3;
    const SEKOLAH_SEHAT = 4;
    const SEKOLAH_KEPENDUDUKAN = 5;
    const SEKOLAH_RAWAN_BENCANA = 6;
    const SEKOLAH_DESC_PENGGERAK = "Sekolah Penggerak";
    const SEKOLAH_DESC_ADIWIYATA = "Sekolah Adiwiyata";
    const SEKOLAH_DESC_RAMAH_ANAK = "Sekolah Ramah Anak";
    const SEKOLAH_DESC_SEHAT = "Sekolah Sehat";
    const SEKOLAH_DESC_KEPENDUDUKAN = "Sekolah Kependukukan";
    const SEKOLAH_DESC_RAWAN_BENCANA = "Sekolah Rawan Bencana";

    public function listPredikatSekolah($name="id") {
        if ($name=="id")
            return array(
                self::SEKOLAH_PENGGERAK, 
                self::SEKOLAH_ADIWIYATA, 
                self::SEKOLAH_RAMAH_ANAK, 
                self::SEKOLAH_SEHAT, 
                self::SEKOLAH_KEPENDUDUKAN, 
                self::SEKOLAH_RAWAN_BENCANA, 
            );
        else
            return array(
                self::SEKOLAH_DESC_PENGGERAK, 
                self::SEKOLAH_DESC_ADIWIYATA,
                self::SEKOLAH_DESC_RAMAH_ANAK,
                self::SEKOLAH_DESC_SEHAT,
                self::SEKOLAH_DESC_KEPENDUDUKAN,
                self::SEKOLAH_DESC_RAWAN_BENCANA,
            );
    }

    const AKREDITASI_A = 1;
    const AKREDITASI_B = 2;
    const AKREDITASI_C = 3;
    const AKREDTIASI_TIDAK_TERAKREDITASI = 4;
    const AKREDITASI_DESC_A = "A";
    const AKREDITASI_DESC_B = "B";
    const AKREDITASI_DESC_C = "C";
    const AKREDTIASI_DESC_TIDAK_TERAKREDITASI = "Tidak Terakreditasi";

    const SERTIFIKAT_LAHAN_ADA = 1;
    const SERTIFIKAT_LAHAN_BELUM_ADA = 2;
    const SERTIFIKAT_LAHAN_DESC_ADA = "Ada";
    const SERTIFIKAT_LAHAN_DESC_BELUM_ADA = "Belum Ada";
    
    
    const MASTER_PLAN_SEKOLAH_ADA = 1;
    const MASTER_PLAN_SEKOLAH_BELUM_ADA = 2;
    const MASTER_PLAN_SEKOLAH_DESC_ADA = "Ada";
    const MASTER_PLAN_SEKOLAH_DESC_BELUM_ADA = "Belum Ada";

    const JENIS_KELAMIN_LAKI_LAKI = 1;
    const JENIS_KELAMIN_PEREMPUAN = 2;
    const JENIS_KELAMIN_DESC_LAKI_LAKI = "Laki - Laki";
    const JENIS_KELAMIN_DESC_PEREMPUAN = "Perempuan";

    const STATUS_GURU_PNS = 1;
    const STATUS_GURU_PTK = 2;
    const STATUS_GURU_THL = 3;
    const STATUS_GURU_DESC_PNS = "PNS";
    const STATUS_GURU_DESC_PTK = "PTK";
    const STATUS_GURU_DESC_THL = "THL";

    const KELAS_X = 1;
    const KELAS_XI = 2;
    const KELAS_XII = 3;
    const KELAS_DESC_X = "X";
    const KELAS_DESC_XI = "XI";
    const KELAS_DESC_XII = "XII";

    const SARPRAS_UTAMA = 1;
    const SARPRAS_PENUNJANG = 2;
    const SARPRAS_PERALATAN = 3;
    const SARPRAS_DESC_UTAMA = "Sarpras Utama";
    const SARPRAS_DESC_PENUNJANG = "Sarpras Penunjang";
    const SARPRAS_DESC_PERALATAN = "Sarpras Peralatan";

    public function listJenisSarpras($name="id") {
        if($name=="id")
            return array(
                self::SARPRAS_UTAMA,
                self::SARPRAS_PENUNJANG,
                self::SARPRAS_PERALATAN
            );
        else
            return array(
                self::SARPRAS_DESC_UTAMA,
                self::SARPRAS_DESC_PENUNJANG,
                self::SARPRAS_DESC_PERALATAN
            );
    }

    const KONDISI_SARPRAS_BAIK = 1;
    const KONDISI_SARPRAS_RUSAK_BERAT = 2;
    const KONDISI_SARPRAS_RUSAK_SEDANG = 3;
    const KONDISI_SARPRAS_RUSAK_RINGAN = 4;
    const KONDISI_SARPRAS_BELUM_SELESAI = 5;
    const KONDISI_SARPRAS_DESC_BAIK = 'Baik';
    const KONDISI_SARPRAS_DESC_RUSAK_BERAT = 'Rusak Berat';
    const KONDISI_SARPRAS_DESC_RUSAK_SEDANG = 'Rusak Sedang';
    const KONDISI_SARPRAS_DESC_RUSAK_RINGAN = 'Rusak Ringan';
    const KONDISI_SARPRAS_DESC_BELUM_SELESAI = 'Belum Selesai';

    public function listKondisiSarpras($name="id") {
        if ($name=="id")
            return array(
                self::KONDISI_SARPRAS_BAIK, 
                self::KONDISI_SARPRAS_RUSAK_BERAT, 
                self::KONDISI_SARPRAS_RUSAK_SEDANG, 
                self::KONDISI_SARPRAS_RUSAK_RINGAN, 
                self::KONDISI_SARPRAS_BELUM_SELESAI, 
            );
        else
            return array(
                self::KONDISI_SARPRAS_DESC_BAIK, 
                self::KONDISI_SARPRAS_DESC_RUSAK_BERAT, 
                self::KONDISI_SARPRAS_DESC_RUSAK_SEDANG, 
                self::KONDISI_SARPRAS_DESC_RUSAK_RINGAN, 
                self::KONDISI_SARPRAS_DESC_BELUM_SELESAI, 
            );
    }




    const JENJANG_PENDIDIKAN_SD = 0;
    const JENJANG_PENDIDIKAN_SMP = 1;
    const JENJANG_PENDIDIKAN_SMA = 2;
    const JENJANG_PENDIDIKAN_D1 = 3;
    const JENJANG_PENDIDIKAN_D2 = 4;
    const JENJANG_PENDIDIKAN_D3 = 5;
    const JENJANG_PENDIDIKAN_S1 = 6;
    const JENJANG_PENDIDIKAN_S2 = 7;
    const JENJANG_PENDIDIKAN_S3 = 8;
    const JENJANG_PENDIDIKAN_DESC_SD = "SD dan Sederajat";
    const JENJANG_PENDIDIKAN_DESC_SMP = "SMP dan Sederajat";
    const JENJANG_PENDIDIKAN_DESC_SMA = "SMA dan Sederajat";
    const JENJANG_PENDIDIKAN_DESC_D1 = "DI";
    const JENJANG_PENDIDIKAN_DESC_D2 = "DII";
    const JENJANG_PENDIDIKAN_DESC_D3 = "DIII";
    const JENJANG_PENDIDIKAN_DESC_S1 = "S1/DIV";
    const JENJANG_PENDIDIKAN_DESC_S2 = "S2";
    const JENJANG_PENDIDIKAN_DESC_S3 = "S3";
    
    public function listJenjangPendidikan($name="id") {
        if ($name=="id")
            return array(self::JENJANG_PENDIDIKAN_SD, self::JENJANG_PENDIDIKAN_SMP, self::JENJANG_PENDIDIKAN_SMA, self::JENJANG_PENDIDIKAN_D1, self::JENJANG_PENDIDIKAN_D2, self::JENJANG_PENDIDIKAN_D3, self::JENJANG_PENDIDIKAN_S1, self::JENJANG_PENDIDIKAN_S2, self::JENJANG_PENDIDIKAN_S3);
        else
            return array(self::JENJANG_PENDIDIKAN_DESC_SD, self::JENJANG_PENDIDIKAN_DESC_SMP, self::JENJANG_PENDIDIKAN_DESC_SMA, self::JENJANG_PENDIDIKAN_DESC_D1, self::JENJANG_PENDIDIKAN_DESC_D2, self::JENJANG_PENDIDIKAN_DESC_D3, self::JENJANG_PENDIDIKAN_DESC_S1, self::JENJANG_PENDIDIKAN_DESC_S2, self::JENJANG_PENDIDIKAN_DESC_S3);
    }
    public static function getJenjangPendidikan($jenjang) {
        if(is_null($jenjang)) return null;
        else if($jenjang==self::JENJANG_PENDIDIKAN_SD) return self::JENJANG_PENDIDIKAN_DESC_SD;
        else if($jenjang==self::JENJANG_PENDIDIKAN_SMP) return self::JENJANG_PENDIDIKAN_DESC_SMP;
        else if($jenjang==self::JENJANG_PENDIDIKAN_SMA) return self::JENJANG_PENDIDIKAN_DESC_SMA;
        else if($jenjang==self::JENJANG_PENDIDIKAN_D1) return self::JENJANG_PENDIDIKAN_DESC_D1;
        else if($jenjang==self::JENJANG_PENDIDIKAN_D2) return self::JENJANG_PENDIDIKAN_DESC_D2;
        else if($jenjang==self::JENJANG_PENDIDIKAN_D3) return self::JENJANG_PENDIDIKAN_DESC_D3;
        else if($jenjang==self::JENJANG_PENDIDIKAN_S1) return self::JENJANG_PENDIDIKAN_DESC_S1;
        else if($jenjang==self::JENJANG_PENDIDIKAN_S2) return self::JENJANG_PENDIDIKAN_DESC_S2;
        else if($jenjang==self::JENJANG_PENDIDIKAN_S3) return self::JENJANG_PENDIDIKAN_DESC_S3;
        else return "";
    }
    const PENGALAMAN_KURANG_1_TAHUN = 0;
    const PENGALAMAN_1_TAHUN = 1;
    const PENGALAMAN_2_TAHUN = 2;
    const PENGALAMAN_3_TAHUN = 3;
    const PENGALAMAN_4_TAHUN = 4;
    const PENGALAMAN_5_TAHUN = 5;
    const PENGALAMAN_LEBIH_5_TAHUN = 6;
    const PENGALAMAN_DESC_KURANG_1_TAHUN = "Kurang dari 1 Tahun";
    const PENGALAMAN_DESC_1_TAHUN = "1 Tahun";
    const PENGALAMAN_DESC_2_TAHUN = "2 Tahun";
    const PENGALAMAN_DESC_3_TAHUN = "3 Tahun";
    const PENGALAMAN_DESC_4_TAHUN = "4 Tahun";
    const PENGALAMAN_DESC_5_TAHUN = "5 Tahun";
    const PENGALAMAN_DESC_LEBIH_5_TAHUN = "Lebih dari 5 Tahun";
    public function listPengalaman($name="id") {
        if ($name=="id")
            return array(self:: PENGALAMAN_KURANG_1_TAHUN, self:: PENGALAMAN_1_TAHUN, self:: PENGALAMAN_2_TAHUN, self:: PENGALAMAN_3_TAHUN, self:: PENGALAMAN_4_TAHUN, self:: PENGALAMAN_5_TAHUN, self:: PENGALAMAN_LEBIH_5_TAHUN);
        else
            return array(self:: PENGALAMAN_DESC_KURANG_1_TAHUN, self:: PENGALAMAN_DESC_1_TAHUN, self:: PENGALAMAN_DESC_2_TAHUN, self:: PENGALAMAN_DESC_3_TAHUN, self:: PENGALAMAN_DESC_4_TAHUN, self:: PENGALAMAN_DESC_5_TAHUN, self:: PENGALAMAN_DESC_LEBIH_5_TAHUN);
    }
    public static function getPengalaman($pengalaman) {
        if(is_null($pengalaman)) return null;
        else if($pengalaman==self::PENGALAMAN_KURANG_1_TAHUN) return self::PENGALAMAN_DESC_KURANG_1_TAHUN;
        else if($pengalaman==self::PENGALAMAN_1_TAHUN) return self::PENGALAMAN_DESC_1_TAHUN;
        else if($pengalaman==self::PENGALAMAN_2_TAHUN) return self::PENGALAMAN_DESC_2_TAHUN;
        else if($pengalaman==self::PENGALAMAN_3_TAHUN) return self::PENGALAMAN_DESC_3_TAHUN;
        else if($pengalaman==self::PENGALAMAN_4_TAHUN) return self::PENGALAMAN_DESC_4_TAHUN;
        else if($pengalaman==self::PENGALAMAN_5_TAHUN) return self::PENGALAMAN_DESC_5_TAHUN;
        else if($pengalaman==self::PENGALAMAN_LEBIH_5_TAHUN) return self::PENGALAMAN_DESC_LEBIH_5_TAHUN;
        else return "";
    }
    const STATUS_PERMODALAN_PMDN = 0;
    const STATUS_PERMODALAN_PMA = 1;
    const STATUS_PERMODALAN_NEGARA = 2;
    const STATUS_PERMODALAN_GABUNGAN = 3;
    const STATUS_PERMODALAN_LAINNYA = 4;
    const STATUS_PERMODALAN_DESC_PMDN =  "PMDN";
    const STATUS_PERMODALAN_DESC_PMA =  "PMA";
    const STATUS_PERMODALAN_DESC_NEGARA =  "Negara (BUMN, Persero, dsb)";
    const STATUS_PERMODALAN_DESC_GABUNGAN =  "Gabungan";
    const STATUS_PERMODALAN_DESC_LAINNYA =  "Lainnya";
    public function listStatusPermodalan($name="id") {
        if ($name=="id")
            return array(self::STATUS_PERMODALAN_PMDN, self::STATUS_PERMODALAN_PMA, self::STATUS_PERMODALAN_NEGARA, self::STATUS_PERMODALAN_GABUNGAN, self::STATUS_PERMODALAN_LAINNYA);
        else
            return array(self::STATUS_PERMODALAN_DESC_PMDN, self::STATUS_PERMODALAN_DESC_PMA, self::STATUS_PERMODALAN_DESC_NEGARA, self::STATUS_PERMODALAN_DESC_GABUNGAN, self::STATUS_PERMODALAN_DESC_LAINNYA);
    }
    const STATUS_NAKER_PKWT = 1;
    const STATUS_NAKER_PKWTT = 2;

    const STATUS_NAKER_DESC_PKWT = "PKWT";
    const STATUS_NAKER_DESC_PKWTT = "PKWTT";
    public static function listStatusNaker($name="id") {
        if ($name=="id")
            return array(self::STATUS_NAKER_PKWT, self::STATUS_NAKER_PKWTT);
        else
            return array(self::STATUS_NAKER_DESC_PKWT, self::STATUS_NAKER_DESC_PKWTT);
    }
    public static function getStatusNaker($status) {
        if(is_null($status)) return null;
        else if($status==self::STATUS_NAKER_PKWT) return self::STATUS_NAKER_DESC_PKWT;
        else if($status==self::STATUS_NAKER_PKWTT) return self::STATUS_NAKER_DESC_PKWTT;
        else return "";
    }
    const STATUS_PELAMAR_MELAMAR = 0;
    const STATUS_PELAMAR_DITERIMA = 1;
    const STATUS_PELAMAR_TIDAK_DITERIMA = 2;

    const STATUS_PELAMAR_DESC_MELAMAR = "Melamar";
    const STATUS_PELAMAR_DESC_DITERIMA = "Diterima";
    const STATUS_PELAMAR_DESC_TIDAK_DITERIMA = "Tidak Diterima";

    const LEGALISIR_DIAJUKAN = 0;
    const LEGALISIR_DISETUJUI = 1;
    const LEGALISIR_DITOLAK = 2;

    const LEGALISIR_DESC_DIAJUKAN = "Permintaan Pengajuan Legalisir Ijazah";
    const LEGALISIR_DESC_DISETUJUI = "Pengajuan Legalisir Ijazah Di setujui";
    const LEGALISIR_DESC_DITOLAK = "Pengajuan Legalisir Ijazah Di tolak";
    
    public static function statusLegalisir($status) {
        if(is_null($status)) return null;
        else if($status==self::LEGALISIR_DIAJUKAN) return self::LEGALISIR_DESC_DIAJUKAN;
        else if($status==self::LEGALISIR_DISETUJUI) return self::LEGALISIR_DESC_DISETUJUI;
        else if($status==self::LEGALISIR_DITOLAK) return self::LEGALISIR_DESC_DITOLAK;
        else return "";
    }

    //UNIT 
    const UNIT_OPD = 1;
    const UNIT_SEKOLAH = 2;
    const UNIT_DESC_OPD =  "OPD";
    const UNIT_DESC_SEKOLAH =  "Sekolah";
    public function listUnit($name="id") {
        if ($name=="id")
            return array(self::UNIT_OPD, self::UNIT_SEKOLAH);
        else
        return array(self::UNIT_DESC_OPD, self::UNIT_DESC_SEKOLAH);
    }

    //Jabatan OPD
    const JABATAN_OPD_KEPALADINAS = 1;
    const JABATAN_OPD_STAFDINAS = 2;

    const JABATAN_OPD_DESC_KEPALADINAS =  "Kepala Dinas";
    const JABATAN_OPD_DESC_STAFDINAS =  "Staf Dinas Pendidikan";
    public function listJabatanOPD($name="id") {
        if ($name=="id")
            return array(self::JABATAN_OPD_KEPALADINAS, self::JABATAN_OPD_STAFDINAS);
        else
        return array(self::JABATAN_OPD_DESC_KEPALADINAS, self::JABATAN_OPD_DESC_STAFDINAS);
    }

    //Jabatan Sekolah
    const JABATAN_SEKOLAH_KEPALASEKOLAH = 1;
    const JABATAN_SEKOLAH_BENDAHARABOS = 2;
    const JABATAN_SEKOLAH_BENDAHARASPP = 3;
    const JABATAN_SEKOLAH_PENGURUSBARANG = 4;

    const JABATAN_SEKOLAH_DESC_KEPALASEKOLAH =  "Kepala Sekolah";
    const JABATAN_SEKOLAH_DESC_BENDAHARABOS =  "Bendahara Bos";
    const JABATAN_SEKOLAH_DESC_BENDAHARASPP =  "Bendahara SPP";
    const JABATAN_SEKOLAH_DESC_PENGURUSBARANG =  "Pengurus Barang";

    public function listJabatanSekolah($name="id") {
        if ($name=="id")
            return array(self::JABATAN_SEKOLAH_KEPALASEKOLAH, self::JABATAN_SEKOLAH_BENDAHARABOS, self::JABATAN_SEKOLAH_BENDAHARASPP, self::JABATAN_SEKOLAH_PENGURUSBARANG);
        else
        return array(self::JABATAN_SEKOLAH_DESC_KEPALASEKOLAH, self::JABATAN_SEKOLAH_DESC_BENDAHARABOS, self::JABATAN_SEKOLAH_DESC_BENDAHARASPP, self::JABATAN_SEKOLAH_DESC_PENGURUSBARANG);
    }

    public function getDescJabatanOPD($status)
	{
		$result = "";
		if ($status == enumVar::JABATAN_OPD_KEPALADINAS) {
			$result = enumVar::JABATAN_OPD_DESC_KEPALADINAS;
		} elseif ($status == enumVar::JABATAN_OPD_STAFDINAS) {
			$result = enumVar::JABATAN_OPD_DESC_STAFDINAS;
        }
		return $result;
	}

    public function getDescJabatanSekolah($status)
	{
		$result = "";
		if ($status == enumVar::JABATAN_SEKOLAH_KEPALASEKOLAH) {
			$result = enumVar::JABATAN_SEKOLAH_DESC_KEPALASEKOLAH;
		} elseif ($status == enumVar::JABATAN_SEKOLAH_BENDAHARABOS) {
			$result =  enumVar::JABATAN_SEKOLAH_DESC_BENDAHARABOS;
        } elseif ($status == enumVar::JABATAN_SEKOLAH_BENDAHARASPP){
            $result = enumVar::JABATAN_SEKOLAH_DESC_BENDAHARABOS;
        } elseif ($status == enumVar::JABATAN_SEKOLAH_PENGURUSBARANG){
            $result = enumVar::JABATAN_SEKOLAH_DESC_PENGURUSBARANG;
        }
		return $result;
	}

    // Jenis Pagu

    const JENIS_PAGU_KONSULTAN_PERENCANAAN = 1;
    const JENIS_PAGU_KONSULTAN_PENGAWAS = 2;
    const JENIS_PAGU_BANGUNAN = 3;
    const JENIS_PAGU_PENGADAAN = 4;
    const JENIS_PAGU_ADMINISTRASI = 5;

    const JENIS_PAGU_DESC_KONSULTAN_PERENCANAAN = 'Konsultan Perencanaan';
    const JENIS_PAGU_DESC_KONSULTAN_PENGAWAS = 'Konsultan Pengawasan';
    const JENIS_PAGU_DESC_BANGUNAN = 'Bangunan';
    const JENIS_PAGU_DESC_PENGADAAN = 'Pengadaan';
    const JENIS_PAGU_DESC_ADMINISTRASI = 'Administrasi';

    public function listJenisPagu($name="id") {
        if ($name=="id")
            return array(
                self::JENIS_PAGU_KONSULTAN_PERENCANAAN, 
                self::JENIS_PAGU_KONSULTAN_PENGAWAS, 
                self::JENIS_PAGU_BANGUNAN, 
                self::JENIS_PAGU_PENGADAAN,
                self::JENIS_PAGU_ADMINISTRASI
            );
        else
        return array(
                self::JENIS_PAGU_DESC_KONSULTAN_PERENCANAAN, 
                self::JENIS_PAGU_DESC_KONSULTAN_PENGAWAS, 
                self::JENIS_PAGU_DESC_BANGUNAN, 
                self::JENIS_PAGU_DESC_PENGADAAN,
                self::JENIS_PAGU_DESC_ADMINISTRASI
            );
    }


    const SUMBER_DANA_DAK = 1;
    const SUMBER_DANA_BOS = 2;
    const SUMBER_DANA_SPP = 3;
    const SUMBER_DANA_APBD = 4;

    const SUMBER_DANA_DESC_DAK = 'DAK';
    const SUMBER_DANA_DESC_BOS = 'BOS';
    const SUMBER_DANA_DESC_SPP = 'SPP';
    const SUMBER_DANA_DESC_APBD = 'APBD';

    public function listSumberDana($name="id") {
        if ($name=="id")
            return array(
                self::SUMBER_DANA_DAK, 
                self::SUMBER_DANA_BOS, 
                self::SUMBER_DANA_SPP, 
                self::SUMBER_DANA_APBD
            );
        else
            return array(
                self::SUMBER_DANA_DESC_DAK, 
                self::SUMBER_DANA_DESC_BOS, 
                self::SUMBER_DANA_DESC_SPP, 
                self::SUMBER_DANA_DESC_APBD
            );
    }

    const STATUS_KEBUTUHAN_SARPRAS_DITOLAK = 0;
    const STATUS_KEBUTUHAN_SARPRAS_DRAFT = 1;
    const STATUS_KEBUTUHAN_SARPRAS_PENGAJUAN = 2;
    const STATUS_KEBUTUHAN_SARPRAS_DISETUJUI = 3;
    const STATUS_KEBUTUHAN_SARPRAS_PROSES_TENDER = 5;
    const STATUS_KEBUTUHAN_SARPRAS_PROGRES_PEMBANGUNAN = 6;
    const STATUS_KEBUTUHAN_SARPRAS_PROGRES_SELESAI = 7;


    const STATUS_KEBUTUHAN_SARPRAS_DESC_DITOLAK = 'Pengajuan Kebutuhan Sarpras Ditolak';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_DRAFT = 'Draft';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_PENGAJUAN = 'Pengajuan Kebutuhan Sarpras';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_DISETUJUI = 'Pengajuan Kebutuhan Sarpras Disetujui';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_PROSES_TENDER = 'Proses Tender';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_PEMBANGUNAN = 'Progres Pembangunan';
    const STATUS_KEBUTUHAN_SARPRAS_DESC_PROGRES_SELESAI = 'Selesai';


    const BULAN_1 = 1;
    const BULAN_2 = 2;
    const BULAN_3 = 3;
    const BULAN_4 = 4;
    const BULAN_5 = 5;
    const BULAN_6 = 6;
    const BULAN_7 = 7;
    const BULAN_8 = 8;
    const BULAN_9 = 9;
    const BULAN_10 = 10;
    const BULAN_11 = 11;
    const BULAN_12 = 12;

    const BULAN_DESC_1 = 'Bulan ke 1';
    const BULAN_DESC_2 = 'Bulan ke 2';
    const BULAN_DESC_3 = 'Bulan ke 3';
    const BULAN_DESC_4 = 'Bulan ke 4';
    const BULAN_DESC_5 = 'Bulan ke 5';
    const BULAN_DESC_6 = 'Bulan ke 6';
    const BULAN_DESC_7 = 'Bulan ke 7';
    const BULAN_DESC_8 = 'Bulan ke 8';
    const BULAN_DESC_9 = 'Bulan ke 9';
    const BULAN_DESC_10 = 'Bulan ke 10';
    const BULAN_DESC_11 = 'Bulan ke 11';
    const BULAN_DESC_12 = 'Bulan ke 12';

    public function listUrutanBulan($name="id") {
        if($name=="id") {
            return array(
                self::BULAN_1,
                self::BULAN_2,
                self::BULAN_3,
                self::BULAN_4,
                self::BULAN_5,
                self::BULAN_6,
                self::BULAN_7,
                self::BULAN_8,
                self::BULAN_9,
                self::BULAN_10,
                self::BULAN_11,
                self::BULAN_12,
            );
        }else {
            return array(
                self::BULAN_DESC_1,
                self::BULAN_DESC_2,
                self::BULAN_DESC_3,
                self::BULAN_DESC_4,
                self::BULAN_DESC_5,
                self::BULAN_DESC_6,
                self::BULAN_DESC_7,
                self::BULAN_DESC_8,
                self::BULAN_DESC_9,
                self::BULAN_DESC_10,
                self::BULAN_DESC_11,
                self::BULAN_DESC_12,
            );
        }
    }


    const MINGGU_1 = 1;
    const MINGGU_2 = 2;
    const MINGGU_3 = 3;
    const MINGGU_4 = 4;
    const MINGGU_5 = 5;
    const MINGGU_6 = 6;
    const MINGGU_7 = 7;
    const MINGGU_8 = 8;
    const MINGGU_9 = 9;
    const MINGGU_10 = 10;
    const MINGGU_11 = 11;
    const MINGGU_12 = 12;
    const MINGGU_13 = 13;
    const MINGGU_14 = 14;
    const MINGGU_15 = 15;
    const MINGGU_16 = 16;
    const MINGGU_17 = 17;
    const MINGGU_18 = 18;
    const MINGGU_19 = 19;
    const MINGGU_20 = 20;
    const MINGGU_21 = 21;
    const MINGGU_22 = 22;
    const MINGGU_23 = 23;
    const MINGGU_24 = 24;
    const MINGGU_25 = 25;
    const MINGGU_26 = 26;
    const MINGGU_27 = 27;
    const MINGGU_28 = 28;
    const MINGGU_29 = 29;
    const MINGGU_30 = 30;
    const MINGGU_31 = 31;
    const MINGGU_32 = 32;
    const MINGGU_33 = 33;
    const MINGGU_34 = 34;
    const MINGGU_35 = 35;
    const MINGGU_36 = 36;
    const MINGGU_37 = 37;
    const MINGGU_38 = 38;
    const MINGGU_39 = 39;
    const MINGGU_40 = 40;
    const MINGGU_41 = 41;
    const MINGGU_42 = 42;
    const MINGGU_43 = 43;
    const MINGGU_44 = 44;
    const MINGGU_45 = 45;
    const MINGGU_46 = 46;
    const MINGGU_47 = 47;
    const MINGGU_48 = 48;
    const MINGGU_49 = 49;
    const MINGGU_50 = 50;
    const MINGGU_51 = 51;
    const MINGGU_52 = 52;

    const MINGGU_DESC_1 = 'Minggu 1';
    const MINGGU_DESC_2 = 'Minggu 2';
    const MINGGU_DESC_3 = 'Minggu 3';
    const MINGGU_DESC_4 = 'Minggu 4';
    const MINGGU_DESC_5 = 'Minggu 5';
    const MINGGU_DESC_6 = 'Minggu 6';
    const MINGGU_DESC_7 = 'Minggu 7';
    const MINGGU_DESC_8 = 'Minggu 8';
    const MINGGU_DESC_9 = 'Minggu 9';
    const MINGGU_DESC_10 = 'Minggu 10';
    const MINGGU_DESC_11 = 'Minggu 11';
    const MINGGU_DESC_12 = 'Minggu 12';
    const MINGGU_DESC_13 = 'Minggu 13';
    const MINGGU_DESC_14 = 'Minggu 14';
    const MINGGU_DESC_15 = 'Minggu 15';
    const MINGGU_DESC_16 = 'Minggu 16';
    const MINGGU_DESC_17 = 'Minggu 17';
    const MINGGU_DESC_18 = 'Minggu 18';
    const MINGGU_DESC_19 = 'Minggu 19';
    const MINGGU_DESC_20 = 'Minggu 20';
    const MINGGU_DESC_21 = 'Minggu 21';
    const MINGGU_DESC_22 = 'Minggu 22';
    const MINGGU_DESC_23 = 'Minggu 23';
    const MINGGU_DESC_24 = 'Minggu 24';
    const MINGGU_DESC_25 = 'Minggu 25';
    const MINGGU_DESC_26 = 'Minggu 26';
    const MINGGU_DESC_27 = 'Minggu 27';
    const MINGGU_DESC_28 = 'Minggu 28';
    const MINGGU_DESC_29 = 'Minggu 29';
    const MINGGU_DESC_30 = 'Minggu 30';
    const MINGGU_DESC_31 = 'Minggu 31';
    const MINGGU_DESC_32 = 'Minggu 32';
    const MINGGU_DESC_33 = 'Minggu 33';
    const MINGGU_DESC_34 = 'Minggu 34';
    const MINGGU_DESC_35 = 'Minggu 35';
    const MINGGU_DESC_36 = 'Minggu 36';
    const MINGGU_DESC_37 = 'Minggu 37';
    const MINGGU_DESC_38 = 'Minggu 38';
    const MINGGU_DESC_39 = 'Minggu 39';
    const MINGGU_DESC_40 = 'Minggu 40';
    const MINGGU_DESC_41 = 'Minggu 41';
    const MINGGU_DESC_42 = 'Minggu 42';
    const MINGGU_DESC_43 = 'Minggu 43';
    const MINGGU_DESC_44 = 'Minggu 44';
    const MINGGU_DESC_45 = 'Minggu 45';
    const MINGGU_DESC_46 = 'Minggu 46';
    const MINGGU_DESC_47 = 'Minggu 47';
    const MINGGU_DESC_48 = 'Minggu 48';
    const MINGGU_DESC_49 = 'Minggu 49';
    const MINGGU_DESC_50 = 'Minggu 50';
    const MINGGU_DESC_51 = 'Minggu 51';
    const MINGGU_DESC_52 = 'Minggu 52';


    public function listMinggu($name="id") {
        if ($name=="id")
            return array(
                self::MINGGU_1, 
                self::MINGGU_2, 
                self::MINGGU_3, 
                self::MINGGU_4, 
                self::MINGGU_5, 
                self::MINGGU_6, 
                self::MINGGU_7, 
                self::MINGGU_8, 
                self::MINGGU_9, 
                self::MINGGU_10,
                self::MINGGU_11,
                self::MINGGU_12,
                self::MINGGU_13,
                self::MINGGU_14,
                self::MINGGU_15,
                self::MINGGU_16,
                self::MINGGU_17,
                self::MINGGU_18,
                self::MINGGU_19,
                self::MINGGU_20,
                self::MINGGU_21,
                self::MINGGU_22,
                self::MINGGU_23,
                self::MINGGU_24,
                self::MINGGU_25,
                self::MINGGU_26,
                self::MINGGU_27,
                self::MINGGU_28,
                self::MINGGU_29,
                self::MINGGU_30,
                self::MINGGU_31,
                self::MINGGU_32,
                self::MINGGU_33,
                self::MINGGU_34,
                self::MINGGU_35,
                self::MINGGU_36,
                self::MINGGU_37,
                self::MINGGU_38,
                self::MINGGU_39,
                self::MINGGU_40,
                self::MINGGU_41,
                self::MINGGU_42,
                self::MINGGU_43,
                self::MINGGU_44,
                self::MINGGU_45,
                self::MINGGU_46,
                self::MINGGU_47,
                self::MINGGU_48,
                self::MINGGU_49,
                self::MINGGU_50,
                self::MINGGU_51,
                self::MINGGU_52, 
            );
        else
        return array(
            self::MINGGU_DESC_1,
            self::MINGGU_DESC_2,
            self::MINGGU_DESC_3,
            self::MINGGU_DESC_4,
            self::MINGGU_DESC_5,
            self::MINGGU_DESC_6,
            self::MINGGU_DESC_7,
            self::MINGGU_DESC_8,
            self::MINGGU_DESC_9,
            self::MINGGU_DESC_10,
            self::MINGGU_DESC_11,
            self::MINGGU_DESC_12,
            self::MINGGU_DESC_13,
            self::MINGGU_DESC_14,
            self::MINGGU_DESC_15,
            self::MINGGU_DESC_16,
            self::MINGGU_DESC_17,
            self::MINGGU_DESC_18,
            self::MINGGU_DESC_19,
            self::MINGGU_DESC_20,
            self::MINGGU_DESC_21,
            self::MINGGU_DESC_22,
            self::MINGGU_DESC_23,
            self::MINGGU_DESC_24,
            self::MINGGU_DESC_25,
            self::MINGGU_DESC_26,
            self::MINGGU_DESC_27,
            self::MINGGU_DESC_28,
            self::MINGGU_DESC_29,
            self::MINGGU_DESC_30,
            self::MINGGU_DESC_31,
            self::MINGGU_DESC_32,
            self::MINGGU_DESC_33,
            self::MINGGU_DESC_34,
            self::MINGGU_DESC_35,
            self::MINGGU_DESC_36,
            self::MINGGU_DESC_37,
            self::MINGGU_DESC_38,
            self::MINGGU_DESC_39,
            self::MINGGU_DESC_40,
            self::MINGGU_DESC_41,
            self::MINGGU_DESC_42,
            self::MINGGU_DESC_43,
            self::MINGGU_DESC_44,
            self::MINGGU_DESC_45,
            self::MINGGU_DESC_46,
            self::MINGGU_DESC_47,
            self::MINGGU_DESC_48,
            self::MINGGU_DESC_49,
            self::MINGGU_DESC_50,
            self::MINGGU_DESC_51,
            self::MINGGU_DESC_52,
        );
    }

    const JENIS_KEBUTUHAN_PENGADAAN = 1;
    const JENIS_KEBUTUHAN_PEMELIHARAAN = 2;
    const JENIS_KEBUTUHAN_PEMBANGUNAN = 3;

    const JENIS_KEBUTUHAN_DESC_PENGADAAN = 'Pengadaan';
    const JENIS_KEBUTUHAN_DESC_PEMELIHARAAN = 'Pemeliharaan';
    const JENIS_KEBUTUHAN_DESC_PEMBANGUNAN = 'Pembangunan';

    public function listJenisKebutuhan($name="id") {
        if ($name=="id")
            return array(
                self::JENIS_KEBUTUHAN_PENGADAAN, 
                self::JENIS_KEBUTUHAN_PEMELIHARAAN, 
                self::JENIS_KEBUTUHAN_PEMBANGUNAN
            );
        else
        return array(
            self::JENIS_KEBUTUHAN_DESC_PENGADAAN, 
            self::JENIS_KEBUTUHAN_DESC_PEMELIHARAAN, 
            self::JENIS_KEBUTUHAN_DESC_PEMBANGUNAN, 
        );
    }
}
?>