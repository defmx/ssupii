DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insAlum`(OUT id varchar(20),nom varchar(100),app varchar(100),apm varchar(100),cid int,bid int,sem int,yr int)
BEGIN
if id is null then select uuid() into id;
end if;
INSERT calum(_id,nom,app,apm,bid,cid,sem,yr) SELECT id,nom,app,apm,bid,cid,sem,yr;
END$$
DELIMITER ;
