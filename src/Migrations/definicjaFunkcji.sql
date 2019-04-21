CREATE FUNCTION `integerToInterval` (miesiaceWszyst integer)
RETURNS varchar(25)
BEGIN
	DECLARE lata int;
    DECLARE miesiace int;
    DECLARE wynik varchar(25);
    SET lata = FLOOR(miesiaceWszyst/12);
    SET miesiace = miesiaceWszyst - lata*12;
    SET wynik = CONCAT('+P',CAST(lata as CHAR(2)),'Y',CAST(miesiace as CHAR(2)),'M00DT00H00M00S');
	
RETURN wynik;
END
