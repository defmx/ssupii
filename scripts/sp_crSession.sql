CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crSession`(OUT id varchar(36),uid varchar(20),guest_name varchar(30),guest_ip varchar(16))
BEGIN
	SELECT uuid() into id;
    INSERT ksess SELECT id,uid,1000,0,now(),guest_name,guest_ip;
END