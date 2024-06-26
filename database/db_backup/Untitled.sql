PGDMP                       {            management_umkm    11.20    16.0 n    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    18148    management_umkm    DATABASE     q   CREATE DATABASE management_umkm WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'C';
    DROP DATABASE management_umkm;
                postgres    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                postgres    false            �           0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    6            �            1259    18178    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public            postgres    false    6            �            1259    18176    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    202    6            �           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    201            �            1259    18151 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public            postgres    false    6            �            1259    18149    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    6    197            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    196            �            1259    18169    password_resets    TABLE     �   CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 #   DROP TABLE public.password_resets;
       public            postgres    false    6            �            1259    18192    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public            postgres    false    6            �            1259    18190    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    204    6            �           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    203            �            1259    18293    tbalokasibudget    TABLE     �  CREATE TABLE public.tbalokasibudget (
    alokasibudgetid bigint NOT NULL,
    budgetid bigint NOT NULL,
    judul character varying(255) NOT NULL,
    tglalokasibudget date NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false,
    alokasibudget double precision
);
 #   DROP TABLE public.tbalokasibudget;
       public            postgres    false    6            �            1259    18291 #   tbalokasibudget_alokasibudgetid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbalokasibudget_alokasibudgetid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 :   DROP SEQUENCE public.tbalokasibudget_alokasibudgetid_seq;
       public          postgres    false    6    222            �           0    0 #   tbalokasibudget_alokasibudgetid_seq    SEQUENCE OWNED BY     k   ALTER SEQUENCE public.tbalokasibudget_alokasibudgetid_seq OWNED BY public.tbalokasibudget.alokasibudgetid;
          public          postgres    false    221            �            1259    18281    tbbudget    TABLE     �  CREATE TABLE public.tbbudget (
    budgetid bigint NOT NULL,
    rekeningid bigint NOT NULL,
    judul character varying(255) NOT NULL,
    tglbudget date NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false,
    totalbudget double precision
);
    DROP TABLE public.tbbudget;
       public            postgres    false    6            �            1259    18279    tbbudget_budgetid_seq    SEQUENCE     ~   CREATE SEQUENCE public.tbbudget_budgetid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.tbbudget_budgetid_seq;
       public          postgres    false    220    6            �           0    0    tbbudget_budgetid_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.tbbudget_budgetid_seq OWNED BY public.tbbudget.budgetid;
          public          postgres    false    219            �            1259    18235    tbbudgetmanagement    TABLE     J  CREATE TABLE public.tbbudgetmanagement (
    budgetid bigint NOT NULL,
    anggaran character varying(255) NOT NULL,
    uraiananggaran character varying(255) NOT NULL,
    kodeanggaran character varying(255) NOT NULL,
    norek character varying(255) NOT NULL,
    detailanggaran character varying(255) NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
 &   DROP TABLE public.tbbudgetmanagement;
       public            postgres    false    6            �            1259    18233    tbbudgetmanagement_budgetid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbbudgetmanagement_budgetid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.tbbudgetmanagement_budgetid_seq;
       public          postgres    false    212    6            �           0    0    tbbudgetmanagement_budgetid_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.tbbudgetmanagement_budgetid_seq OWNED BY public.tbbudgetmanagement.budgetid;
          public          postgres    false    211            �            1259    18305    tbdetailalokasibudget    TABLE     �  CREATE TABLE public.tbdetailalokasibudget (
    detailalokasibudgetid bigint NOT NULL,
    alokasibudgetid bigint NOT NULL,
    judul character varying(255) NOT NULL,
    deskripsi character varying(255) NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
 )   DROP TABLE public.tbdetailalokasibudget;
       public            postgres    false    6            �            1259    18303 /   tbdetailalokasibudget_detailalokasibudgetid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbdetailalokasibudget_detailalokasibudgetid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 F   DROP SEQUENCE public.tbdetailalokasibudget_detailalokasibudgetid_seq;
       public          postgres    false    6    224            �           0    0 /   tbdetailalokasibudget_detailalokasibudgetid_seq    SEQUENCE OWNED BY     �   ALTER SEQUENCE public.tbdetailalokasibudget_detailalokasibudgetid_seq OWNED BY public.tbdetailalokasibudget.detailalokasibudgetid;
          public          postgres    false    223            �            1259    18260    tbfilestock    TABLE     �  CREATE TABLE public.tbfilestock (
    filestockid bigint NOT NULL,
    file character varying(255) NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false,
    stockid bigint NOT NULL
);
    DROP TABLE public.tbfilestock;
       public            postgres    false    6            �            1259    18258    tbfilestock_filestockid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbfilestock_filestockid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.tbfilestock_filestockid_seq;
       public          postgres    false    216    6            �           0    0    tbfilestock_filestockid_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.tbfilestock_filestockid_seq OWNED BY public.tbfilestock.filestockid;
          public          postgres    false    215            �            1259    18206    tbmakses    TABLE     �  CREATE TABLE public.tbmakses (
    aksesid bigint NOT NULL,
    akseskode character varying(10),
    aksesnama character varying(100),
    status boolean,
    keterangan character varying(255),
    grup smallint,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
    DROP TABLE public.tbmakses;
       public            postgres    false    6            �            1259    18204    tbmakses_aksesid_seq    SEQUENCE     }   CREATE SEQUENCE public.tbmakses_aksesid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.tbmakses_aksesid_seq;
       public          postgres    false    206    6            �           0    0    tbmakses_aksesid_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.tbmakses_aksesid_seq OWNED BY public.tbmakses.aksesid;
          public          postgres    false    205            �            1259    18226    tbmaksesmenu    TABLE     �  CREATE TABLE public.tbmaksesmenu (
    aksesmenuid bigint NOT NULL,
    aksesid bigint,
    menuid bigint,
    tambah boolean,
    ubah boolean,
    hapus boolean,
    lihat boolean,
    cetak boolean,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
     DROP TABLE public.tbmaksesmenu;
       public            postgres    false    6            �            1259    18224    tbmaksesmenu_aksesmenuid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbmaksesmenu_aksesmenuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.tbmaksesmenu_aksesmenuid_seq;
       public          postgres    false    6    210            �           0    0    tbmaksesmenu_aksesmenuid_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.tbmaksesmenu_aksesmenuid_seq OWNED BY public.tbmaksesmenu.aksesmenuid;
          public          postgres    false    209            �            1259    18218    tbmmenu    TABLE     �   CREATE TABLE public.tbmmenu (
    menuid bigint NOT NULL,
    parent character varying(100),
    menu character varying(100),
    url character varying(100),
    urutan smallint,
    ishide boolean,
    jenis smallint
);
    DROP TABLE public.tbmmenu;
       public            postgres    false    6            �            1259    18216    tbmmenu_menuid_seq    SEQUENCE     {   CREATE SEQUENCE public.tbmmenu_menuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.tbmmenu_menuid_seq;
       public          postgres    false    208    6            �           0    0    tbmmenu_menuid_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.tbmmenu_menuid_seq OWNED BY public.tbmmenu.menuid;
          public          postgres    false    207            �            1259    18269 
   tbrekening    TABLE     �  CREATE TABLE public.tbrekening (
    rekeningid bigint NOT NULL,
    koderekening character varying(255) NOT NULL,
    bank character varying(255) NOT NULL,
    saldo double precision NOT NULL,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
    DROP TABLE public.tbrekening;
       public            postgres    false    6            �            1259    18267    tbrekening_rekeningid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbrekening_rekeningid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.tbrekening_rekeningid_seq;
       public          postgres    false    218    6            �           0    0    tbrekening_rekeningid_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.tbrekening_rekeningid_seq OWNED BY public.tbrekening.rekeningid;
          public          postgres    false    217            �            1259    18247    tbstockmanagement    TABLE     �  CREATE TABLE public.tbstockmanagement (
    stockid bigint NOT NULL,
    kodestock character varying(255) NOT NULL,
    namastock character varying(255) NOT NULL,
    jumlah integer NOT NULL,
    harga double precision,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
 %   DROP TABLE public.tbstockmanagement;
       public            postgres    false    6            �            1259    18245    tbstockmanagement_stockid_seq    SEQUENCE     �   CREATE SEQUENCE public.tbstockmanagement_stockid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.tbstockmanagement_stockid_seq;
       public          postgres    false    214    6            �           0    0    tbstockmanagement_stockid_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.tbstockmanagement_stockid_seq OWNED BY public.tbstockmanagement.stockid;
          public          postgres    false    213            �            1259    18159    tbuser    TABLE     �  CREATE TABLE public.tbuser (
    userid bigint NOT NULL,
    grup smallint,
    pegawaiid bigint,
    nama character varying(255),
    login character varying(255),
    password character varying(255) NOT NULL,
    isaktif boolean,
    email character varying(255),
    aksesid bigint,
    email_verified_at timestamp(0) without time zone,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    opadd character varying(50),
    pcadd character varying(20),
    tgladd timestamp(0) without time zone NOT NULL,
    opedit character varying(50),
    pcedit character varying(20),
    tgledit timestamp(0) without time zone NOT NULL,
    dlt boolean DEFAULT false
);
    DROP TABLE public.tbuser;
       public            postgres    false    6            �            1259    18157    tbusers_userid_seq    SEQUENCE     {   CREATE SEQUENCE public.tbusers_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.tbusers_userid_seq;
       public          postgres    false    6    199            �           0    0    tbusers_userid_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE public.tbusers_userid_seq OWNED BY public.tbuser.userid;
          public          postgres    false    198                       2604    18181    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    202    201    202                       2604    18154    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    196    197    197                       2604    18195    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    203    204    204            ,           2604    18296    tbalokasibudget alokasibudgetid    DEFAULT     �   ALTER TABLE ONLY public.tbalokasibudget ALTER COLUMN alokasibudgetid SET DEFAULT nextval('public.tbalokasibudget_alokasibudgetid_seq'::regclass);
 N   ALTER TABLE public.tbalokasibudget ALTER COLUMN alokasibudgetid DROP DEFAULT;
       public          postgres    false    222    221    222            *           2604    18284    tbbudget budgetid    DEFAULT     v   ALTER TABLE ONLY public.tbbudget ALTER COLUMN budgetid SET DEFAULT nextval('public.tbbudget_budgetid_seq'::regclass);
 @   ALTER TABLE public.tbbudget ALTER COLUMN budgetid DROP DEFAULT;
       public          postgres    false    220    219    220            "           2604    18238    tbbudgetmanagement budgetid    DEFAULT     �   ALTER TABLE ONLY public.tbbudgetmanagement ALTER COLUMN budgetid SET DEFAULT nextval('public.tbbudgetmanagement_budgetid_seq'::regclass);
 J   ALTER TABLE public.tbbudgetmanagement ALTER COLUMN budgetid DROP DEFAULT;
       public          postgres    false    212    211    212            .           2604    18308 +   tbdetailalokasibudget detailalokasibudgetid    DEFAULT     �   ALTER TABLE ONLY public.tbdetailalokasibudget ALTER COLUMN detailalokasibudgetid SET DEFAULT nextval('public.tbdetailalokasibudget_detailalokasibudgetid_seq'::regclass);
 Z   ALTER TABLE public.tbdetailalokasibudget ALTER COLUMN detailalokasibudgetid DROP DEFAULT;
       public          postgres    false    224    223    224            &           2604    18263    tbfilestock filestockid    DEFAULT     �   ALTER TABLE ONLY public.tbfilestock ALTER COLUMN filestockid SET DEFAULT nextval('public.tbfilestock_filestockid_seq'::regclass);
 F   ALTER TABLE public.tbfilestock ALTER COLUMN filestockid DROP DEFAULT;
       public          postgres    false    215    216    216                       2604    18209    tbmakses aksesid    DEFAULT     t   ALTER TABLE ONLY public.tbmakses ALTER COLUMN aksesid SET DEFAULT nextval('public.tbmakses_aksesid_seq'::regclass);
 ?   ALTER TABLE public.tbmakses ALTER COLUMN aksesid DROP DEFAULT;
       public          postgres    false    205    206    206                        2604    18229    tbmaksesmenu aksesmenuid    DEFAULT     �   ALTER TABLE ONLY public.tbmaksesmenu ALTER COLUMN aksesmenuid SET DEFAULT nextval('public.tbmaksesmenu_aksesmenuid_seq'::regclass);
 G   ALTER TABLE public.tbmaksesmenu ALTER COLUMN aksesmenuid DROP DEFAULT;
       public          postgres    false    210    209    210                       2604    18221    tbmmenu menuid    DEFAULT     p   ALTER TABLE ONLY public.tbmmenu ALTER COLUMN menuid SET DEFAULT nextval('public.tbmmenu_menuid_seq'::regclass);
 =   ALTER TABLE public.tbmmenu ALTER COLUMN menuid DROP DEFAULT;
       public          postgres    false    207    208    208            (           2604    18272    tbrekening rekeningid    DEFAULT     ~   ALTER TABLE ONLY public.tbrekening ALTER COLUMN rekeningid SET DEFAULT nextval('public.tbrekening_rekeningid_seq'::regclass);
 D   ALTER TABLE public.tbrekening ALTER COLUMN rekeningid DROP DEFAULT;
       public          postgres    false    218    217    218            $           2604    18250    tbstockmanagement stockid    DEFAULT     �   ALTER TABLE ONLY public.tbstockmanagement ALTER COLUMN stockid SET DEFAULT nextval('public.tbstockmanagement_stockid_seq'::regclass);
 H   ALTER TABLE public.tbstockmanagement ALTER COLUMN stockid DROP DEFAULT;
       public          postgres    false    213    214    214                       2604    18162    tbuser userid    DEFAULT     o   ALTER TABLE ONLY public.tbuser ALTER COLUMN userid SET DEFAULT nextval('public.tbusers_userid_seq'::regclass);
 <   ALTER TABLE public.tbuser ALTER COLUMN userid DROP DEFAULT;
       public          postgres    false    198    199    199            �          0    18178    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    202   l�       �          0    18151 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    197   ��       �          0    18169    password_resets 
   TABLE DATA           C   COPY public.password_resets (email, token, created_at) FROM stdin;
    public          postgres    false    200   Ò       �          0    18192    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
    public          postgres    false    204   ��       �          0    18293    tbalokasibudget 
   TABLE DATA           �   COPY public.tbalokasibudget (alokasibudgetid, budgetid, judul, tglalokasibudget, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt, alokasibudget) FROM stdin;
    public          postgres    false    222   ��       �          0    18281    tbbudget 
   TABLE DATA           �   COPY public.tbbudget (budgetid, rekeningid, judul, tglbudget, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt, totalbudget) FROM stdin;
    public          postgres    false    220   �       �          0    18235    tbbudgetmanagement 
   TABLE DATA           �   COPY public.tbbudgetmanagement (budgetid, anggaran, uraiananggaran, kodeanggaran, norek, detailanggaran, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    212   7�       �          0    18305    tbdetailalokasibudget 
   TABLE DATA           �   COPY public.tbdetailalokasibudget (detailalokasibudgetid, alokasibudgetid, judul, deskripsi, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    224   T�       �          0    18260    tbfilestock 
   TABLE DATA           u   COPY public.tbfilestock (filestockid, file, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt, stockid) FROM stdin;
    public          postgres    false    216   q�       �          0    18206    tbmakses 
   TABLE DATA           �   COPY public.tbmakses (aksesid, akseskode, aksesnama, status, keterangan, grup, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    206   }�       �          0    18226    tbmaksesmenu 
   TABLE DATA           �   COPY public.tbmaksesmenu (aksesmenuid, aksesid, menuid, tambah, ubah, hapus, lihat, cetak, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    210   ��       �          0    18218    tbmmenu 
   TABLE DATA           S   COPY public.tbmmenu (menuid, parent, menu, url, urutan, ishide, jenis) FROM stdin;
    public          postgres    false    208   ��       �          0    18269 
   tbrekening 
   TABLE DATA              COPY public.tbrekening (rekeningid, koderekening, bank, saldo, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    218   Ԕ       �          0    18247    tbstockmanagement 
   TABLE DATA           �   COPY public.tbstockmanagement (stockid, kodestock, namastock, jumlah, harga, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    214   �       �          0    18159    tbuser 
   TABLE DATA           �   COPY public.tbuser (userid, grup, pegawaiid, nama, login, password, isaktif, email, aksesid, email_verified_at, remember_token, created_at, updated_at, opadd, pcadd, tgladd, opedit, pcedit, tgledit, dlt) FROM stdin;
    public          postgres    false    199   q�       �           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    201            �           0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 15, true);
          public          postgres    false    196            �           0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    203                        0    0 #   tbalokasibudget_alokasibudgetid_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('public.tbalokasibudget_alokasibudgetid_seq', 1, false);
          public          postgres    false    221                       0    0    tbbudget_budgetid_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.tbbudget_budgetid_seq', 1, false);
          public          postgres    false    219                       0    0    tbbudgetmanagement_budgetid_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.tbbudgetmanagement_budgetid_seq', 1, false);
          public          postgres    false    211                       0    0 /   tbdetailalokasibudget_detailalokasibudgetid_seq    SEQUENCE SET     ^   SELECT pg_catalog.setval('public.tbdetailalokasibudget_detailalokasibudgetid_seq', 1, false);
          public          postgres    false    223                       0    0    tbfilestock_filestockid_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.tbfilestock_filestockid_seq', 3, true);
          public          postgres    false    215                       0    0    tbmakses_aksesid_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.tbmakses_aksesid_seq', 1, false);
          public          postgres    false    205                       0    0    tbmaksesmenu_aksesmenuid_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.tbmaksesmenu_aksesmenuid_seq', 1, false);
          public          postgres    false    209                       0    0    tbmmenu_menuid_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.tbmmenu_menuid_seq', 1, false);
          public          postgres    false    207                       0    0    tbrekening_rekeningid_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.tbrekening_rekeningid_seq', 1, false);
          public          postgres    false    217            	           0    0    tbstockmanagement_stockid_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.tbstockmanagement_stockid_seq', 3, true);
          public          postgres    false    213            
           0    0    tbusers_userid_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.tbusers_userid_seq', 6, true);
          public          postgres    false    198            6           2606    18187    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    202            8           2606    18189 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    202            1           2606    18156    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    197            :           2606    18200 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    204            <           2606    18203 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    204            O           2606    18302 $   tbalokasibudget tbalokasibudget_pkey 
   CONSTRAINT     o   ALTER TABLE ONLY public.tbalokasibudget
    ADD CONSTRAINT tbalokasibudget_pkey PRIMARY KEY (alokasibudgetid);
 N   ALTER TABLE ONLY public.tbalokasibudget DROP CONSTRAINT tbalokasibudget_pkey;
       public            postgres    false    222            M           2606    18290    tbbudget tbbudget_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.tbbudget
    ADD CONSTRAINT tbbudget_pkey PRIMARY KEY (budgetid);
 @   ALTER TABLE ONLY public.tbbudget DROP CONSTRAINT tbbudget_pkey;
       public            postgres    false    220            E           2606    18244 *   tbbudgetmanagement tbbudgetmanagement_pkey 
   CONSTRAINT     n   ALTER TABLE ONLY public.tbbudgetmanagement
    ADD CONSTRAINT tbbudgetmanagement_pkey PRIMARY KEY (budgetid);
 T   ALTER TABLE ONLY public.tbbudgetmanagement DROP CONSTRAINT tbbudgetmanagement_pkey;
       public            postgres    false    212            Q           2606    18314 0   tbdetailalokasibudget tbdetailalokasibudget_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.tbdetailalokasibudget
    ADD CONSTRAINT tbdetailalokasibudget_pkey PRIMARY KEY (detailalokasibudgetid);
 Z   ALTER TABLE ONLY public.tbdetailalokasibudget DROP CONSTRAINT tbdetailalokasibudget_pkey;
       public            postgres    false    224            I           2606    18266    tbfilestock tbfilestock_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY public.tbfilestock
    ADD CONSTRAINT tbfilestock_pkey PRIMARY KEY (filestockid);
 F   ALTER TABLE ONLY public.tbfilestock DROP CONSTRAINT tbfilestock_pkey;
       public            postgres    false    216            ?           2606    18215    tbmakses tbmakses_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.tbmakses
    ADD CONSTRAINT tbmakses_pkey PRIMARY KEY (aksesid);
 @   ALTER TABLE ONLY public.tbmakses DROP CONSTRAINT tbmakses_pkey;
       public            postgres    false    206            C           2606    18232    tbmaksesmenu tbmaksesmenu_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public.tbmaksesmenu
    ADD CONSTRAINT tbmaksesmenu_pkey PRIMARY KEY (aksesmenuid);
 H   ALTER TABLE ONLY public.tbmaksesmenu DROP CONSTRAINT tbmaksesmenu_pkey;
       public            postgres    false    210            A           2606    18223    tbmmenu tbmmenu_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.tbmmenu
    ADD CONSTRAINT tbmmenu_pkey PRIMARY KEY (menuid);
 >   ALTER TABLE ONLY public.tbmmenu DROP CONSTRAINT tbmmenu_pkey;
       public            postgres    false    208            K           2606    18278    tbrekening tbrekening_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.tbrekening
    ADD CONSTRAINT tbrekening_pkey PRIMARY KEY (rekeningid);
 D   ALTER TABLE ONLY public.tbrekening DROP CONSTRAINT tbrekening_pkey;
       public            postgres    false    218            G           2606    18256 (   tbstockmanagement tbstockmanagement_pkey 
   CONSTRAINT     k   ALTER TABLE ONLY public.tbstockmanagement
    ADD CONSTRAINT tbstockmanagement_pkey PRIMARY KEY (stockid);
 R   ALTER TABLE ONLY public.tbstockmanagement DROP CONSTRAINT tbstockmanagement_pkey;
       public            postgres    false    214            3           2606    18168    tbuser tbusers_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY public.tbuser
    ADD CONSTRAINT tbusers_pkey PRIMARY KEY (userid);
 =   ALTER TABLE ONLY public.tbuser DROP CONSTRAINT tbusers_pkey;
       public            postgres    false    199            4           1259    18175    password_resets_email_index    INDEX     X   CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);
 /   DROP INDEX public.password_resets_email_index;
       public            postgres    false    200            =           1259    18201 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    204    204            �      x������ � �      �   *  x�u��n� ���a���]�LP��B#��~Q�x��1��f��Gȏ��L �<��i'*��W2��x��V�+y
�"w�A^�f��Y�p퍫�˫��!��-fB�u��FZnSGSH@��7�}�f�t�eG�D���<Ӳ%��QY��=�f|��Pq�'�n����YLOQ
Ij~HRB>�n����bN��J�i1�Ӽf��˘+(%�X{r���Mۼ�L�`{�c��D��q���V�0,��F1�95�y /��YQ�s�ɍ���95�2]���ӿ��c��,��      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   �   x���Kn�0�5�"J�whO0�@)y	B�s�fTUb1�.*{c���ɼ 5�@����#~&��Гݤd�d<�[��M,�"A?�?�i^4��*��؏�6�����b���a�oy߰����W�.���J�rx�G�8�r!)� w���C���U8�?��!�n�!:tH[�q3��/i�D�=|:V��]e)z�Oh)���M���7hG&���p!t'�$c_��#���� {&^�]��*��ɡ�      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   p   x�3�I-.������ť�E�)��y��F�z@h�id`d�kh�kh�```ejheb��B�dҸ�9�@2�F�f������@�-�2���������0�4�=... k)�      �   |   x�3�4���.-H-JL����,F0U�*UTL�
}�]R�*�Rs��"�JJ��3�K�R-�*�L\}�â�܊C�SK��8K@�GCFFƺ��f
�V&�V�xdҸb���� �J,�     