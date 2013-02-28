CREATE TABLE user_role
(
  role_id character varying(255) NOT NULL,
  "default" smallint NOT NULL,
  parent character varying(255) DEFAULT NULL::character varying,
  CONSTRAINT user_role_pkey PRIMARY KEY (role_id )
)
WITH (
  OIDS=FALSE
);

CREATE TABLE user_role_linker
(
  user_id integer NOT NULL,
  role_id character varying(255) NOT NULL,
  CONSTRAINT user_role_linker_pkey PRIMARY KEY (user_id , role_id )
)
WITH (
  OIDS=FALSE
);

CREATE TABLE uzytkownicy
(
  user_id serial NOT NULL,
  username character varying(255) DEFAULT NULL::character varying,
  email character varying(255) DEFAULT NULL::character varying,
  display_name character varying(50) DEFAULT NULL::character varying,
  password character varying(128) NOT NULL,
  state smallint,
  CONSTRAINT user_pkey PRIMARY KEY (user_id ),
  CONSTRAINT user_email_key UNIQUE (email ),
  CONSTRAINT user_username_key UNIQUE (username )
)
WITH (
  OIDS=FALSE
);
