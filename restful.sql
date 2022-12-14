PGDMP     :                    z           restful    14.5    14.5     ?           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            ?           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            ?           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            ?           1262    16395    restful    DATABASE     k   CREATE DATABASE restful WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE restful;
                postgres    false            ?           0    0    DATABASE restful    COMMENT     .   COMMENT ON DATABASE restful IS 'Api example';
                   postgres    false    3317            ?            1259    24608    codes    TABLE     ?   CREATE TABLE public.codes (
    id integer NOT NULL,
    code character(50),
    email character(50),
    created_at character(150)
);
    DROP TABLE public.codes;
       public         heap    postgres    false            ?            1259    24611    codes_id_seq    SEQUENCE     ?   ALTER TABLE public.codes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.codes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    211            ?            1259    16396    users    TABLE     ?   CREATE TABLE public.users (
    id integer NOT NULL,
    firstname character(50),
    lastname character(50),
    email character(50),
    admin boolean,
    state boolean,
    password character(255)
);
    DROP TABLE public.users;
       public         heap    postgres    false            ?           0    0    COLUMN users.state    COMMENT     R   COMMENT ON COLUMN public.users.state IS 'Active or deactivated user ( account )';
          public          postgres    false    209            ?            1259    24606    users_id_seq    SEQUENCE     ?   ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    209            ?          0    24608    codes 
   TABLE DATA           <   COPY public.codes (id, code, email, created_at) FROM stdin;
    public          postgres    false    211   /       ?          0    16396    users 
   TABLE DATA           W   COPY public.users (id, firstname, lastname, email, admin, state, password) FROM stdin;
    public          postgres    false    209   ?       ?           0    0    codes_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.codes_id_seq', 1, true);
          public          postgres    false    212            ?           0    0    users_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.users_id_seq', 1, true);
          public          postgres    false    210            ?   U   x?3?w	r
6v
wv	q17??R 8?s2???2?R??2??s3s???s?h1202?5??50S04?2??25$l?W? ??*?      ?   |   x?3?t??L?/??JU p'e&??%fK1H?Cznbf?^r~.-%@?bT?bh?b??^??W?j????_b\Z??k??WT\eQ??횤????]h??danF?'?????? ? J?     