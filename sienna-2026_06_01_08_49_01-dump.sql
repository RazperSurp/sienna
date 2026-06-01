--
-- PostgreSQL database dump
--

-- Dumped from database version 14.20
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: auth_assignment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_assignment (
    item_name character varying(64) NOT NULL,
    user_id character varying(64) NOT NULL,
    created_at integer
);


ALTER TABLE public.auth_assignment OWNER TO postgres;

--
-- Name: auth_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_item (
    name character varying(64) NOT NULL,
    type smallint NOT NULL,
    description text,
    rule_name character varying(64),
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_item OWNER TO postgres;

--
-- Name: auth_item_child; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_item_child (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.auth_item_child OWNER TO postgres;

--
-- Name: auth_rule; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_rule (
    name character varying(64) NOT NULL,
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_rule OWNER TO postgres;

--
-- Name: clubs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clubs (
    id integer NOT NULL,
    name text NOT NULL,
    balance integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.clubs OWNER TO postgres;

--
-- Name: club_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.club_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.club_id_seq OWNER TO postgres;

--
-- Name: club_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.club_id_seq OWNED BY public.clubs.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO postgres;

--
-- Name: transaction; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.transaction (
    id integer NOT NULL,
    club_id integer NOT NULL,
    value integer DEFAULT 0 NOT NULL,
    comment text NOT NULL
);


ALTER TABLE public.transaction OWNER TO postgres;

--
-- Name: transaction_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.transaction_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transaction_id_seq OWNER TO postgres;

--
-- Name: transaction_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.transaction_id_seq OWNED BY public.transaction.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    first_name text NOT NULL,
    second_name text NOT NULL,
    third_name text,
    password_hash text NOT NULL,
    auth_token text,
    club_id integer,
    email text NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: user_fullname; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.user_fullname AS
 SELECT users.id,
    concat_ws(' '::text, users.second_name, users.first_name, users.third_name) AS full_name
   FROM public.users;


ALTER TABLE public.user_fullname OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_id_seq OWNED BY public.users.id;


--
-- Name: clubs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clubs ALTER COLUMN id SET DEFAULT nextval('public.club_id_seq'::regclass);


--
-- Name: transaction id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.transaction ALTER COLUMN id SET DEFAULT nextval('public.transaction_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: auth_assignment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_assignment (item_name, user_id, created_at) FROM stdin;
admin	2	1780132103
clubPresident	1	1780168956
clubMember	3	1780221449
\.


--
-- Data for Name: auth_item; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_item (name, type, description, rule_name, data, created_at, updated_at) FROM stdin;
viewClub	2	Просмотр странички клуба	\N	\N	1779998127	1779998127
createEvent	2	Организация ивента	\N	\N	1779998127	1779998127
changeClub	2	Перевод в другой клуб	\N	\N	1779998127	1779998127
manageTokens	2	Распоряжение токенами клуба	\N	\N	1779998127	1779998127
regNewMember	2	Зарегистрировать нового участника клуба	\N	\N	1779998127	1779998127
editClubInfo	2	Редактировать информации о клубе	\N	\N	1779998127	1779998127
regNewClub	2	Регистрация нового клуба	\N	\N	1779998127	1779998127
sendTokens	2	Отправить токены на счет клуба	\N	\N	1779998127	1779998127
changeClubPresident	2	Изменить председателя клуба	\N	\N	1779998127	1779998127
guest	1	Гость	\N	\N	1779998127	1779998127
clubMember	1	Участник клуба	\N	\N	1779998127	1779998127
clubPresident	1	Председатель клуба	\N	\N	1779998127	1779998127
admin	1	Администратор	\N	\N	1779998127	1779998127
\.


--
-- Data for Name: auth_item_child; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_item_child (parent, child) FROM stdin;
guest	viewClub
clubMember	viewClub
clubMember	createEvent
clubMember	changeClub
clubPresident	viewClub
clubPresident	createEvent
clubPresident	manageTokens
clubPresident	regNewMember
clubPresident	editClubInfo
admin	viewClub
admin	createEvent
admin	regNewMember
admin	editClubInfo
admin	regNewClub
admin	sendTokens
admin	changeClubPresident
\.


--
-- Data for Name: auth_rule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_rule (name, data, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: clubs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clubs (id, name, balance) FROM stdin;
2	test	0
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1779991093
m140506_102106_rbac_init	1779991456
m170907_052038_rbac_add_index_on_auth_assignment_user_id	1779991456
m180523_151638_rbac_updates_indexes_without_prefix	1779991456
m200409_110543_rbac_update_mssql_trigger	1779991456
\.


--
-- Data for Name: transaction; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.transaction (id, club_id, value, comment) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, first_name, second_name, third_name, password_hash, auth_token, club_id, email) FROM stdin;
2	2	2	2	$2y$13$IJvFQF.czGl2KWVAgaaLOOz5JQ05EWs2v6WMK1JhBnf/YYVR3Lhki	Ye1EWVAZ6vSQ3mclY3AlvwFgyzt3nBnd	\N	2@2.com
1	1	1	1	$2y$13$cM197rWFUQnuCe.vcOmsQe74lvEkjiuyQOHgRh0EtpQBGKs7efx/C	S5FHwdgcir2lXL9icBVs8IprdYcY1NhU	2	1@1.com
3	testMember	aaaa	bbbbb	$2y$13$bJI.hTym7vwYhEW1IoiyuulwgvvDS8cTKMF7kpUB/h8d5ccfkrFNK	qGR0mGa2JPsUB3JjA-CfY5QkV6Vh07PS	2	test@test.com
\.


--
-- Name: club_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.club_id_seq', 2, true);


--
-- Name: transaction_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.transaction_id_seq', 1, false);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_id_seq', 3, true);


--
-- Name: auth_assignment auth_assignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_pkey PRIMARY KEY (item_name, user_id);


--
-- Name: auth_item_child auth_item_child_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_pkey PRIMARY KEY (parent, child);


--
-- Name: auth_item auth_item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_pkey PRIMARY KEY (name);


--
-- Name: auth_rule auth_rule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_rule
    ADD CONSTRAINT auth_rule_pkey PRIMARY KEY (name);


--
-- Name: clubs clubs_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clubs
    ADD CONSTRAINT clubs_pk PRIMARY KEY (id);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: transaction transaction_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.transaction
    ADD CONSTRAINT transaction_pk PRIMARY KEY (id);


--
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- Name: idx-auth_assignment-user_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "idx-auth_assignment-user_id" ON public.auth_assignment USING btree (user_id);


--
-- Name: idx-auth_item-type; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "idx-auth_item-type" ON public.auth_item USING btree (type);


--
-- Name: auth_assignment auth_assignment_item_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_item_name_fkey FOREIGN KEY (item_name) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_child auth_item_child_child_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_child_fkey FOREIGN KEY (child) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_child auth_item_child_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_parent_fkey FOREIGN KEY (parent) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item auth_item_rule_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_rule_name_fkey FOREIGN KEY (rule_name) REFERENCES public.auth_rule(name) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: transaction transaction_club_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.transaction
    ADD CONSTRAINT transaction_club_id_fk FOREIGN KEY (club_id) REFERENCES public.clubs(id);


--
-- Name: users user_club_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT user_club_id_fk FOREIGN KEY (club_id) REFERENCES public.clubs(id);


--
-- PostgreSQL database dump complete
--

