/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  arizaandres
 * Created: 22/06/2018
 */
ALTER TABLE `PeriodosVirtuales` 
ADD COLUMN `NombrePeriodo` varchar(100) NOT NULL AFTER `CodigoPeriodo`;

UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'PRIMER PERIODO ACADEMICO DE 2018' WHERE `IdPeriodoVirtual` = 1;
UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'SEGUNDO PERIODO ACADEMICO DE 2018' WHERE `IdPeriodoVirtual` = 2;
UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'TERCER PERIODO ACADEMICO DE 2018' WHERE `IdPeriodoVirtual` = 3;
UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'CUARTO PERIODO ACADEMICO DE 2018' WHERE `IdPeriodoVirtual` = 4;
UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'QUINTO PERIODO ACADEMICO DE 2018' WHERE `IdPeriodoVirtual` = 5;
UPDATE `PeriodosVirtuales` SET `NombrePeriodo` = 'PRIMER PERIODO ACADEMICO DE 2019',  `Agno`='2019', `CodigoPeriodo`='20191'  WHERE `IdPeriodoVirtual` = 6;
DELETE FROM `PeriodosVirtuales` WHERE `IdPeriodoVirtual` > 6;

ALTER TABLE `PeriodosVirtuales` 
DROP COLUMN `CodigoModalidadAcademica`,
DROP COLUMN `CodigoCarrera`,
DROP COLUMN `PeriodoFinanciero`,
-- DROP COLUMN `FechaInicioperiodo`,
-- DROP COLUMN `FechaVencimientoPeriodo`,
CHANGE COLUMN `CodigoEstadoPeriodo` `CodigoEstado` int(3) NOT NULL AFTER `NombrePeriodo`,
CHANGE COLUMN `Año` `Agno` int(4) NOT NULL AFTER `IdPeriodoVirtual`;

CREATE TABLE `PeriodoVirtualCarrera`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigoPeriodo` varchar(8) NOT NULL COMMENT 'Periodo financiero, relacionado con la tabla periodo original',
  `idPeriodoVirtual` int(11) NOT NULL COMMENT 'Periodo virtual especifico',
  `codigoModalidadAcademica` char(3) NOT NULL DEFAULT 0 COMMENT 'Codigo de la modalidad academica, si es 0 indica que el registro pertenece a una carrera especifica',
  `codigoCarrera` int(11) NOT NULL DEFAULT 0 COMMENT 'Codigo de la carrera asociada, si es 0 indica que el registro pertenece a una modalidad academiga general',
  `codigoEstadoPeriodo` char(2) NOT NULL COMMENT 'Estado del periodo, relacionado con la tabla estado periodo, indica si el periodo esta vigente , en inscripciones etc',
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime NOT NULL,
  `idUsuarioCreacion` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idUsuarioModificacion` int(11) NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `PeriodoVirtualCarrera` VALUES (1, '20181', 1, '800', 0, '1', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (2, '20181', 2, '800', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (3, '20181', 3, '800', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (4, '20182', 4, '800', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (5, '20182', 5, '800', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (6, '20181', 1, '810', 0, '1', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (7, '20181', 2, '810', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `PeriodoVirtualCarrera` VALUES (8, '20182', 3, '810', 0, '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');	