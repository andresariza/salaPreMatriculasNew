DROP TABLE IF EXISTS `IconMenu`;
CREATE TABLE `IconMenu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMenu` int(11) NOT NULL,
  `referenciaMenu` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'menuboton',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of IconMenu
-- ----------------------------
INSERT INTO `IconMenu` VALUES (1, 80, 'menuBoton', 'fa-check-square-o', '1');
INSERT INTO `IconMenu` VALUES (2, 73, 'menuBoton', 'fa-hospital-o', '1');
INSERT INTO `IconMenu` VALUES (3, 53, 'menuBoton', 'fa-file-pdf-o', '1');
INSERT INTO `IconMenu` VALUES (4, 49, 'menuBoton', 'fa-trophy', '1');
INSERT INTO `IconMenu` VALUES (5, 89, 'menuBoton', 'fa-keyboard-o', '1');
INSERT INTO `IconMenu` VALUES (6, 42, 'menuBoton', 'fa-check-square-o', '1');
INSERT INTO `IconMenu` VALUES (7, 88, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (8, 69, 'menuBoton', 'fa-thumbs-o-up', '1');
INSERT INTO `IconMenu` VALUES (9, 82, 'menuBoton', 'fa-tasks', '1');
INSERT INTO `IconMenu` VALUES (10, 71, 'menuBoton', 'fa-institution', '1');
INSERT INTO `IconMenu` VALUES (11, 77, 'menuBoton', 'fa-slideshare', '1');
INSERT INTO `IconMenu` VALUES (12, 85, 'menuBoton', 'fa-stethoscope', '1');
INSERT INTO `IconMenu` VALUES (13, 34, 'menuBoton', 'fa-money', '1');
INSERT INTO `IconMenu` VALUES (14, 3, 'menuBoton', 'fa-clock-o', '1');
INSERT INTO `IconMenu` VALUES (15, 95, 'menuBoton', 'fa-calendar', '1');
INSERT INTO `IconMenu` VALUES (16, 50, 'menuBoton', 'fa-file-text-o', '1');
INSERT INTO `IconMenu` VALUES (17, 67, 'menuBoton', 'fa-road', '1');
INSERT INTO `IconMenu` VALUES (18, 4, 'menuBoton', ' fa-cubes', '1');
INSERT INTO `IconMenu` VALUES (19, 76, 'menuBoton', 'fa-child', '1');
INSERT INTO `IconMenu` VALUES (20, 94, 'menuBoton', 'fa-bicycle', '1');
INSERT INTO `IconMenu` VALUES (21, 2, 'menuBoton', 'fa-edit', '1');
INSERT INTO `IconMenu` VALUES (22, 92, 'menuBoton', 'fa-calculator', '1');
INSERT INTO `IconMenu` VALUES (23, 43, 'menuBoton', 'fa-eye', '1');
INSERT INTO `IconMenu` VALUES (24, 1, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (25, 5, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (26, 6, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (27, 7, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (28, 8, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (29, 9, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (30, 10, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (31, 11, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (32, 12, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (33, 13, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (34, 14, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (35, 15, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (36, 17, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (37, 18, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (38, 19, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (39, 20, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (40, 21, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (41, 22, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (42, 23, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (43, 24, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (44, 25, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (45, 26, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (46, 27, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (47, 28, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (48, 29, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (49, 30, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (50, 31, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (51, 32, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (52, 33, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (53, 35, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (54, 36, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (55, 37, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (56, 38, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (57, 39, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (58, 40, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (59, 41, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (60, 44, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (61, 45, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (62, 46, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (63, 47, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (64, 48, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (65, 51, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (66, 52, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (67, 54, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (68, 55, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (69, 56, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (70, 57, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (71, 58, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (72, 59, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (73, 60, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (74, 61, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (75, 62, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (76, 63, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (77, 64, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (78, 65, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (79, 66, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (80, 68, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (81, 70, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (82, 72, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (83, 74, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (84, 75, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (85, 78, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (86, 79, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (87, 81, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (88, 86, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (89, 87, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (90, 91, 'menuBoton', 'fa-chevron-right', '1');
INSERT INTO `IconMenu` VALUES (91, 93, 'menuBoton', 'fa-chevron-right', '1');

SET FOREIGN_KEY_CHECKS = 1;


ALTER TABLE `menuboton` 
ADD COLUMN `linkAbsoluto` varchar(255) NULL AFTER `linkmenuboton`;

ALTER TABLE `detalleprematricula` 
ADD COLUMN `idDetallePrematricula` int(11) NOT NULL AUTO_INCREMENT FIRST,
ADD PRIMARY KEY (`idDetallePrematricula`);


/*
 VIEW MateriasMatriculadas
 muestra los datos de prematricula de las materias que se matricularon de forma exitosa
 es decir cuyo estado de prematricula es 40 = Matricula y  cuyo estado detalleprematricula es 30 = Matriculada
*/
CREATE VIEW ViewMateriasMatriculadas AS 
(SELECT dp.idDetallePrematricula,
dp.codigomateria,
dp.codigomateriaelectiva,
dp.codigotipodetalleprematricula,
dp.idgrupo,
dp.numeroordenpago,
p.idprematricula,
p.fechaprematricula,
p.codigoestudiante,
p.codigoperiodo,
p.codigoestadoprematricula,
p.semestreprematricula
FROM detalleprematricula dp
INNER JOIN prematricula p ON (p.idprematricula = dp.idprematricula) 
WHERE p.codigoestadoprematricula = '40'
AND dp.codigoestadodetalleprematricula = '30' 
ORDER BY dp.idDetallePrematricula DESC, p.codigoestudiante DESC);


ALTER TABLE `detallenota` 
ADD COLUMN `idDetalleNota` int(11) NOT NULL AUTO_INCREMENT FIRST,
ADD PRIMARY KEY (`idDetalleNota`);

ALTER TABLE `carrera` 
ADD COLUMN `codigoDiurno` int(11) NULL AFTER `codigocortocarrera`;
UPDATE `carrera` SET codigoDiurno = codigocarrera;
UPDATE `carrera` SET codigoDiurno = 123 WHERE codigocarrera = 124;
UPDATE `carrera` SET codigoDiurno = 118 WHERE codigocarrera = 119;
UPDATE `carrera` SET codigoDiurno = 133 WHERE codigocarrera IN (134, 143);


CREATE OR REPLACE
VIEW `ViewHistoricoNotasEstudiante` AS (
    SELECT n.codigoperiodo, n.notadefinitiva, m.codigomateria, m.numerocreditos, eg.idestudiantegeneral, e.codigoestudiante
    FROM  estudiante e
    INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral)
    INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera)
    INNER JOIN notahistorico n ON (n.codigoestudiante = e.codigoestudiante)
    INNER JOIN materia m ON (m.codigomateria = n.codigomateria)
    WHERE n.codigoestadonotahistorico = '100'
);

ALTER TABLE `periodo` 
ADD COLUMN `PeriodoId` int(11) NOT NULL AUTO_INCREMENT FIRST;