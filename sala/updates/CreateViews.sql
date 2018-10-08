CREATE 
VIEW `ViewMenuOpciones`AS (
  SELECT 
  mu.idmenuopcion AS id, 
  mu.idpadremenuopcion AS parent_id,
  mu.nombremenuopcion AS text,
  mu.linkmenuopcion AS link,
  mu.linkAbsoluto AS linkAbsoluto,
  mu.framedestinomenuopcion AS linkTarget,
  mu.posicionmenuopcion, 
  mu.codigoestadomenuopcion,
  dpmu.codigoestado AS dpmuCodigoEstado,
  pmu.codigoestado AS pmuCodigoEstado,
  pumu.codigoestado AS pumoCodigoEstado,
  u.usuario,
  u.fechainiciousuario,
  u.fechavencimientousuario
  FROM menuopcion mu 
  LEFT JOIN detallepermisomenuopcion dpmu ON dpmu.idmenuopcion = mu.idmenuopcion
  LEFT JOIN permisomenuopcion pmu ON pmu.idpermisomenuopcion = dpmu.idpermisomenuopcion
  LEFT JOIN permisousuariomenuopcion pumu ON pumu.idpermisomenuopcion = pmu.idpermisomenuopcion
  LEFT JOIN usuario u ON u.idusuario = pumu.idusuario
  LEFT JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario 
  ORDER BY u.usuario, mu.nombremenuopcion, mu.idpadremenuopcion, mu.posicionmenuopcion
) ;

CREATE
VIEW `ViewHistoricoNotasEstudiante` AS (
    SELECT n.codigoperiodo, n.notadefinitiva, m.numerocreditos, eg.idestudiantegeneral, e.codigoestudiante
    FROM  estudiante e
    INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral)
    INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera)
    INNER JOIN notahistorico n ON (n.codigoestudiante = e.codigoestudiante)
    INNER JOIN materia m ON (m.codigomateria = n.codigomateria)
    WHERE n.codigoestadonotahistorico = '100'
);