
CREATE OR REPLACE FUNCTION siap_sidang() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF PengumpulanHardCopy  = true AND IjinMajuSidang = true THEN
        UPDATE MATA_KULIAH_SPESIAL SET IsSiapSidang = true
        WHERE PengumpulanHardCopy <> new.PengumpulanHardCopy
        OR IjinMajuSidang <> new.IjinMajuSidang;
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE 'plpgsql';

CREATE TRIGGER cek_siap_sidang
    AFTER UPDATE 
    ON SISIDANG.MATA_KULIAH_SPESIAL
    FOR EACH ROW
    EXECUTE PROCEDURE siap_sidang();

BEGIN;
CREATE OR REPLACE FUNCTION enforce_timeline() RETURNS TRIGGER AS
$BODY$
	BEGIN
    
        IF PengumpulanHardCopy <> new.PengumpulanHardCopy THEN
	        IF current_timestamp > 
	        (
	        	SELECT 	Tanggal
	        	FROM 	SISIDANG.TIMELINE 
	        	WHERE 	NamaEvent = 'Berkas Sidang'
	        		AND	Tahun = new.Tahun
	        		AND Semester = new.Semester
        	) THEN
            	RAISE EXCEPTION 'masa pengumpulan hardcopy telah berlalu';
        	END IF;
        END IF;
        
        IF IjinMajuSidang <> new.IjinMajuSidang THEN
	        IF current_date > 
	        (
	        	SELECT 	Tanggal
	        	FROM 	SISIDANG.TIMELINE 
	        	WHERE 	NamaEvent = 'Pemberian izin maju Sidang oleh pembimbing'
	        		AND	Tahun = new.Tahun
	        		AND Semester = new.Semester
        	) THEN
        	    RAISE EXCEPTION 'masa pemberian izin maju sidang telah berlalu';
        	END IF;
        END IF;
        RETURN NEW;
	END;
$BODY$
LANGUAGE 'plpgsql';

CREATE TRIGGER cek_timeline
    AFTER UPDATE 
    ON SISIDANG.MATA_KULIAH_SPESIAL
    FOR EACH ROW
    EXECUTE PROCEDURE enforce_timeline();

BEGIN;
CREATE OR REPLACE FUNCTION jadwal_dosen() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF current_date > 
    (
    	SELECT 	Tanggal
    	FROM 	SISIDANG.TIMELINE 
    	WHERE 	NamaEvent = 'P'
    		AND	Tahun = new.Tahun
    		AND Semester = new.Semester
    		AND NamaEvent = 'Pengisian jadwal pribadi oleh dosen'
	) THEN
    	RAISE EXCEPTION 'masa pemberian izin maju sidang telah berlalu';
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE 'plpgsql';


CREATE TRIGGER cek_jadwal_dosen
    AFTER UPDATE 
    ON SISIDANG.JADWAL_NON_SIDANG
    FOR EACH ROW
    EXECUTE PROCEDURE jadwal_dosen();
