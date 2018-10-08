CREATE TABLE `IconMenu` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`idMenu`  int(11) NOT NULL ,
`referenciaMenu`  varchar(50) NOT NULL DEFAULT menuboton ,
`icon`  varchar(50) NOT NULL ,
`estado`  varchar(3) NOT NULL DEFAULT 100 ,
PRIMARY KEY (`id`)
)
;