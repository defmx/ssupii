CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insAlum`(OUT id varchar(20),nom varchar(100),app varchar(100),apm varchar(100),cid int,bid int,sem int,yr int,semi int,yri int)
BEGIN
	select coalesce(@id,uuid()) into id;
	INSERT calum(_id,nom,app,apm,bid,cid,sem,yr,semi,yri) SELECT id,ltrim(rtrim(nom)),ltrim(rtrim(app)),ltrim(rtrim(apm)),bid,cid,sem,yr,semi,yri;
END