ALTER TABLE `menuopcion`
ADD COLUMN `linkAbsoluto`  varchar(255) NULL AFTER `linkmenuopcion`;

UPDATE menuopcion 
SET linkAbsoluto = "sala/index.php?option=misCarreras"
WHERE idmenuopcion=220;

UPDATE menuopcion 
SET linkAbsoluto = "sala/?option=cambioPeriodo"
WHERE idmenuopcion=24;

UPDATE menuopcion 
SET linkAbsoluto = "serviciosacademicos/consulta/reportemolinete/reportemolinetebiblio.php"
WHERE idmenuopcion=549;