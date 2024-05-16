CREATE DATABASE kardexadminstracion;
USE kardexadminstracion;

-- Roles para los colaboradores
CREATE TABLE roles
(
	idrol 	INT AUTO_INCREMENT PRIMARY KEY,
    rol 	VARCHAR(3),
    CONSTRAINT rol_uk UNIQUE (rol)
)ENGINE = INNODB;

-- Personas - Pueden existir pero luego ser usadas para la creacion de colaboradores
CREATE TABLE personas 
(
 idpersona		INT AUTO_INCREMENT  PRIMARY KEY,
 apepaterno		VARCHAR(60)	NOT NULL ,
 apepmaterno	VARCHAR(60)	NOT NULL ,
 nombres		VARCHAR(80)	NOT NULL ,
 nrodocumento	CHAR(8)	NOT NULL ,
 telprincipal	CHAR(9)	NOT NULL ,
 telsecundario	CHAR(9)	NULL ,
 fecharegistro	DATETIME NOT NULL DEFAULT NOW(),
 fechabaja		DATETIME NULL,
 CONSTRAINT uk_nro UNIQUE (nrodocumento)
)ENGINE = INNODB;

-- Marcas para los productos
CREATE TABLE marcas
(
	idmarcas INT AUTO_INCREMENT PRIMARY KEY,
    marcas 	VARCHAR(60)
)ENGINE = INNODB;

-- Tipo de producto por ejemplo (Electronico,Ropa,Alimentos,etc)
CREATE TABLE tipoproducto
(
	idtipoproducto INT AUTO_INCREMENT PRIMARY KEY,
    tipoproducto	VARCHAR(70)
)ENGINE = INNODB;


-- Tabla para los colaboradores (Personas + rol)
CREATE TABLE colaboradores
(
	idcolaboradores	INT AUTO_INCREMENT PRIMARY KEY,
    idpersona		INT NOT NULL,
    idrol			INT NOT NULL,
    nomusuario		VARCHAR(100),
    passusuario		VARCHAR(60),
	fecharegistro	DATETIME NOT NULL DEFAULT NOW(),
	fechabaja		DATETIME NULL,
	CONSTRAINT idpersona_rol UNIQUE(idrol,idpersona),
    CONSTRAINT fk_idrol FOREIGN KEY (idrol) REFERENCES roles(idrol),
    CONSTRAINT fk_idpersona FOREIGN KEY(idpersona) REFERENCES personas(idpersona)
)ENGINE = INNODB;

-- Productos (marcas - tipo de producto) 
-- *nota: modelo es dependiendo de la marca,asi que no es necesario agregar uno aparte
CREATE TABLE productos
(
	idproducto		INT AUTO_INCREMENT PRIMARY KEY,
    idmarca			INT NOT NULL,
    idtipoproducto	INT NOT NULL,
    descripcion		VARCHAR(200) NOT NULL,
    modelo			VARCHAR(200) NOT NULL,
	CONSTRAINT fk_idmarca FOREIGN KEY (idmarca) REFERENCES marcas(idmarcas),
    CONSTRAINT fk_idtppro FOREIGN KEY (idtipoproducto) REFERENCES tipoproducto(idtipoproducto)
)ENGINE = INNODB;


CREATE TABLE kardex
(
	idalmacen		INT AUTO_INCREMENT PRIMARY KEY,
    idcolaborador	INT NOT NULL,
    idproducto		INT NOT NULL,
    tipomovimiento	CHAR(3) NOT NULL,
    stockactual		INT NOT NULL,
    cantidad		INT NOT NULL,
    fecharegistro	DATETIME NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_kardex_pr FOREIGN KEY (idproducto) REFERENCES productos(idproducto),
    CONSTRAINT fk_kardex_co FOREIGN KEY (idcolaborador) REFERENCES colaboradores(idcolaboradores),
    CONSTRAINT ck_stock	CHECK (stockactual>=0)
)ENGINE = INNODB;

-- **************************************************************************************
-- **PROCEDURES PARA LAS TABLAS***

DELIMITER $$
CREATE PROCEDURE spu_colaboradores_login(IN _nomuser VARCHAR(100))
BEGIN
	SELECT 
		COL.idcolaboradores,
        PER.apepaterno,
        PER.apepmaterno,
        PER.nombres,
        COL.nomusuario,
        COL.passusuario,
        RL.rol
	FROM colaboradores COL
    LEFT JOIN personas PER ON PER.idpersona = COL.idpersona
    LEFT JOIN roles RL ON RL.idrol = COL.idrol
    WHERE COL.nomusuario = _nomuser AND COL.fechabaja IS NULL;
END $$

-- Procedimeinto kardex de entradas y salidas

DELIMITER $$
CREATE PROCEDURE registrarMovimiento(
    IN p_idcolaborador INT,
    IN p_idproducto INT,
    IN p_tipomovimiento CHAR(3),
    IN p_cantidad SMALLINT
)
BEGIN
    DECLARE v_stockactual INT DEFAULT 0;

    -- Obtener el stock actual
    SELECT stockactual
    INTO v_stockactual
    FROM kardex
    WHERE idproducto = p_idproducto
    ORDER BY fecharegistro DESC
    LIMIT 1;

    IF p_tipomovimiento = 'ENT' THEN
        SET v_stockactual = v_stockactual + p_cantidad;
    ELSEIF p_tipomovimiento = 'SAL' THEN
        IF v_stockactual < p_cantidad THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente';
        ELSE
            SET v_stockactual = v_stockactual - p_cantidad;
        END IF;
    END IF;

    -- Insertar el nuevo movimiento en el Kardex
    INSERT INTO kardex (idcolaborador, idproducto, tipomovimiento, stockactual, cantidad, fecharegistro)
    VALUES (p_idcolaborador, p_idproducto, p_tipomovimiento, v_stockactual, p_cantidad, NOW());
END $$


/* VIEWS PARA LOS PROCEDURES */
CREATE VIEW vs_kardex AS
SELECT 
    K.idalmacen,
    K.fecharegistro,
    P.descripcion AS producto,
    P.modelo,
    K.tipomovimiento,
    K.cantidad,
    K.stockactual,
    COL.nomusuario,
    RL.rol
FROM 
    kardex K
INNER JOIN 
    productos P ON K.idproducto = P.idproducto
INNER JOIN 
    colaboradores COL ON K.idcolaborador = COL.idcolaboradores
INNER JOIN 
    personas PER ON COL.idpersona = PER.idpersona
INNER JOIN 
    roles RL ON COL.idrol = RL.idrol
ORDER BY 
    K.fecharegistro DESC;


/*  MAS PROCEDURES */
DELIMITER $$
CREATE PROCEDURE sp_filtrar_kardex_por_producto(
    IN _nombre_producto VARCHAR(200),
    IN _limit INT
)
BEGIN
    SELECT *
    FROM vs_kardex
    WHERE producto = _nombre_producto
    LIMIT _limit;
END $$


DELIMITER $$
CREATE PROCEDURE sp_registrar_persona(
    IN p_apepaterno VARCHAR(60),
    IN p_apepmaterno VARCHAR(60),
    IN p_nombres VARCHAR(80),
    IN p_nrodocumento CHAR(8),
    IN p_telprincipal CHAR(9),
    IN p_telsecundario CHAR(9)
)
BEGIN
        -- Insertar nueva persona
        INSERT INTO personas (apepaterno, apepmaterno, nombres, nrodocumento, telprincipal, telsecundario, fecharegistro)
        VALUES (p_apepaterno, p_apepmaterno, p_nombres, p_nrodocumento, p_telprincipal, nullif(p_telsecundario,''), NOW());
		SELECT @@last_insert_id 'idpersona';
END $$


DELIMITER $$
CREATE PROCEDURE sp_insertarColaborador(
    IN p_idpersona INT,
    IN p_idrol INT,
    IN p_nomusuario VARCHAR(100),
    IN p_passusuario VARCHAR(60)
)
BEGIN
    -- Insertar colaborador
    INSERT INTO colaboradores (idpersona, idrol, nomusuario, passusuario)
    VALUES (p_idpersona, p_idrol, p_nomusuario, p_passusuario);
    
    -- Obtener el ID del colaborador insertado
    SELECT @@last_insert_id 'idcolaborador';
END $$


CALL sp_filtrar_kardex_por_producto('PlayStation 5', 200);

CALL registrarMovimiento(1, 1, 'SAL', 5);

select * from vs_kardex

