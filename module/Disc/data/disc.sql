CREATE TABLE disc (
  id int(11) NOT NULL auto_increment,
  artist varchar(100) NOT NULL,
  title varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE OR REPLACE FUNCTION fill_disc()
  RETURNS void AS
$BODY$
DECLARE
/*
	Funkcja sluzy do wypelniania tabeli 'disc'
	SELECT fill_disc();
*/
i	integer DEFAULT '200';
j	integer;
BEGIN
FOR j IN 0..i LOOP
	INSERT INTO disc (artist,title) VALUES('artist' || j,'disc' || j);
END LOOP;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION fill_disc()
  OWNER TO postgres;
