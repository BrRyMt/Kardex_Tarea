USE kardexadminstracion;

-- ROLES
INSERT INTO roles (rol) VALUES ('ADM'); -- Adminsitracion
INSERT INTO roles (rol) VALUES ('PRC'); -- Practicante
INSERT INTO roles (rol) VALUES ('SUP'); -- Supervisor
INSERT INTO roles (rol) VALUES ('JSP'); -- Jefe Supervisor

-- PERSONAS
INSERT INTO personas (apepaterno,apepmaterno,nombres,nrodocumento,telprincipal,telsecundario) 
	VALUES ('Mesias','Tasayco','Brayan',73310144,'933293445',''); -- persona de ejemplo 
    
-- MARCAS
INSERT INTO marcas (marcas) VALUES ('Sony');
INSERT INTO marcas (marcas) VALUES ('Samsung');
INSERT INTO marcas (marcas) VALUES ('Nike');
INSERT INTO marcas (marcas) VALUES ('Adidas');
INSERT INTO marcas (marcas) VALUES ('LG');
INSERT INTO marcas (marcas) VALUES ('Apple');
INSERT INTO marcas (marcas) VALUES ('Microsoft');
INSERT INTO marcas (marcas) VALUES ('Puma');
INSERT INTO marcas (marcas) VALUES ('Coca-Cola');
INSERT INTO marcas (marcas) VALUES ('Pepsi');
-- TIPO PRODUCTO
INSERT INTO tipoproducto (tipoproducto) VALUES ('Electrónica');
INSERT INTO tipoproducto (tipoproducto) VALUES ('Ropa');
INSERT INTO tipoproducto (tipoproducto) VALUES ('Hogar');
INSERT INTO tipoproducto (tipoproducto) VALUES ('Alimentos');
INSERT INTO tipoproducto (tipoproducto) VALUES ('Belleza');
INSERT INTO tipoproducto (tipoproducto) VALUES ('Juguetes');
-- COLABORADORES 

INSERT INTO colaboradores (idpersona,idrol,nomusuario,passusuario) 
	VALUES (1,1,'RyanAdmin','');

UPDATE colaboradores 
SET passusuario = "$2y$10$krcPiKl5.zL5zT/3nzqacO89TZLjEMU.m2djyQ35hkLH8eaHrT3.i" 
WHERE idcolaboradores = 1;

-- PRODUCTOS 
INSERT INTO productos (idmarca,idtipoproducto,descripcion,modelo) 
	VALUES (1,1,'PlayStation 5','AFK-123');

-- PROCEDIMIENTOS ALMACENADOS PARA LOS LISTADOS DE COLABORADORES 
DELIMITER $$
CREATE PROCEDURE spu_listar_colaboradores()
BEGIN
	SELECT idcolaboradores,
    PER.idpersona,COL.idrol,COL.nomusuario,
    COL.passusuario,PER.apepaterno,PER.apepmaterno,PER.nombres,
    PER.nrodocumento,PER.telprincipal,PER.telsecundario,
    ROL.rol
    FROM colaboradores COL
    LEFT JOIN personas PER ON PER.idpersona = COL.idpersona
    INNER JOIN roles ROL ON ROL.idrol = COL.idrol;
END$$

-- PROCEDIMIENTOS ALMACENADOS PARA LOS LISTADOS DE PRODUCTOS
DELIMITER $$
CREATE PROCEDURE spu_listar_productos()
BEGIN
	SELECT *
    FROM productos PRC
    INNER JOIN tipoproducto TP ON TP.idtipoproducto = PRC.idtipoproducto
    INNER JOIN marcas MR ON MR.idmarcas = PRC.idmarca;
END$$

-- PROCEDIMIENTO PARA REGISTRAR COLABORADOR
DELIMITER $$
CREATE PROCEDURE spu_registrar_colaboradores(
IN _idpersona		INT,
IN _idrol		 	INT,
IN _nomusuario 		VARCHAR(100),
IN _passusuario		VARCHAR(60)
)
BEGIN
	INSERT INTO colaboradores (idpersona,idrol,nomusuario,passusuario) 
	VALUES (_idpersona,_idrol,_nomusuario,_passusuario);
END$$

-- PROCEDIMIENTO PARA REGISTRAR PRODUCTOS
DELIMITER $$
CREATE PROCEDURE spu_registrar_productos(
IN _marca			INT,
IN _idtipoproducto 	INT,
IN _descripcion 	VARCHAR(200),
IN _modelo			VARCHAR(200)
)
BEGIN
	INSERT INTO productos (idmarca,idtipoproducto,descripcion,modelo) 
	VALUES (_marca,_idtipoproducto,_descripcion,_modelo);
END$$

CALL spu_listar_productos();
CALL spu_listar_colaboradores();
CALL spu_registrar_productos();
CALL spu_registrar_colaboradores();

SELECT * FROM roles;
SELECT * FROM personas;
SELECT * FROM marcas;
SELECT * FROM tipoproducto;
SELECT * FROM colaboradores;
SELECT * FROM productos;
