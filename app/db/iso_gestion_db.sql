-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: 172.17.0.2    Database: iso_gestion
-- ------------------------------------------------------
-- Server version	5.6.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alcances`
--

DROP TABLE IF EXISTS `alcances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alcances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento`
--

DROP TABLE IF EXISTS `documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `revision` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_aprobado` timestamp NULL DEFAULT NULL,
  `fecha_revision` timestamp NULL DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT NULL,
  `fecha_vigencia` timestamp NULL DEFAULT NULL,
  `descripcion` text,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado` (`estado`),
  KEY `estado_2` (`estado`),
  KEY `tipo` (`tipo`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `estado` (`id`),
  CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`tipo`) REFERENCES `tipo_documento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento_alcance`
--

DROP TABLE IF EXISTS `documento_alcance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_alcance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento_id` int(11) NOT NULL,
  `alcance_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `documento_id` (`documento_id`),
  KEY `alcance_id` (`alcance_id`),
  CONSTRAINT `documento_alcance_ibfk_1` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`),
  CONSTRAINT `documento_alcance_ibfk_2` FOREIGN KEY (`alcance_id`) REFERENCES `alcances` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento_log`
--

DROP TABLE IF EXISTS `documento_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `revision` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fecha_aprobado` timestamp NULL DEFAULT NULL,
  `fecha_revision` timestamp NULL DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT NULL,
  `fecha_vigencia` timestamp NULL DEFAULT NULL,
  `descripcion` text,
  `tipo` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  `id_documento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento_usuarios`
--

DROP TABLE IF EXISTS `documento_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_documento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_documento` (`id_documento`,`id_usuario`,`id_rol`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `documento_usuarios_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documento_usuarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documento_usuarios_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3377 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_ultima_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `revision_actual` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_alcance`
--

DROP TABLE IF EXISTS `registro_alcance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_alcance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_id` int(11) NOT NULL,
  `alcance_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `registro_id` (`registro_id`),
  KEY `alcance_id` (`alcance_id`),
  CONSTRAINT `registro_alcance_ibfk_1` FOREIGN KEY (`registro_id`) REFERENCES `registro` (`id`),
  CONSTRAINT `registro_alcance_ibfk_2` FOREIGN KEY (`alcance_id`) REFERENCES `alcances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_alcance_editor`
--

DROP TABLE IF EXISTS `registro_alcance_editor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_alcance_editor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registro_id` int(11) NOT NULL,
  `alcance_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `registro_id` (`registro_id`),
  KEY `alcance_id` (`alcance_id`),
  CONSTRAINT `registro_alcance_editor_ibfk_1` FOREIGN KEY (`registro_id`) REFERENCES `registro` (`id`),
  CONSTRAINT `registro_alcance_editor_ibfk_2` FOREIGN KEY (`alcance_id`) REFERENCES `alcances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_campos`
--

DROP TABLE IF EXISTS `registro_campos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_campos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_registro` int(11) DEFAULT NULL,
  `id_tipo_campo` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_registro` (`id_registro`),
  KEY `id_tipo_campo` (`id_tipo_campo`),
  CONSTRAINT `registro_campos_ibfk_1` FOREIGN KEY (`id_registro`) REFERENCES `registro` (`id`),
  CONSTRAINT `registro_campos_ibfk_2` FOREIGN KEY (`id_tipo_campo`) REFERENCES `tipo_campo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_cargado`
--

DROP TABLE IF EXISTS `registro_cargado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_cargado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_registro` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_registro` (`id_registro`),
  CONSTRAINT `registro_cargado_ibfk_1` FOREIGN KEY (`id_registro`) REFERENCES `registro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=759 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_cargado_dato`
--

DROP TABLE IF EXISTS `registro_cargado_dato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_cargado_dato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_registro_cargado` int(11) NOT NULL,
  `id_registro_campo` int(11) NOT NULL,
  `dato` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  `control_envio_email` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_registro_cargado` (`id_registro_cargado`),
  KEY `id_registro_campo` (`id_registro_campo`),
  CONSTRAINT `registro_cargado_dato_ibfk_1` FOREIGN KEY (`id_registro_cargado`) REFERENCES `registro_cargado` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registro_cargado_dato_ibfk_2` FOREIGN KEY (`id_registro_campo`) REFERENCES `registro_campos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29373 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_control_cambios`
--

DROP TABLE IF EXISTS `registro_control_cambios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_control_cambios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_registro` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `motivo` text NOT NULL,
  `user` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_registro` (`id_registro`),
  KEY `id_usuario` (`user`),
  CONSTRAINT `registro_control_cambios_ibfk_1` FOREIGN KEY (`user`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_campo`
--

DROP TABLE IF EXISTS `tipo_campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_campo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_campo_valor`
--

DROP TABLE IF EXISTS `tipo_campo_valor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_campo_valor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_campo_id` int(11) NOT NULL,
  `valor` int(11) DEFAULT NULL,
  `texto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_campo_valor_1_idx` (`tipo_campo_id`),
  CONSTRAINT `fk_tipo_campo_valor_1` FOREIGN KEY (`tipo_campo_id`) REFERENCES `tipo_campo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nro_documento` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `perfil` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_alcance`
--

INSERT INTO `usuarios` VALUES (1,'admin','Administrador','Administrador','00000000','admin@admin.com','ROLE_ADMIN','d033e22ae348aeb5660fc2140aec35850c4da997');





LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'En proceso de edición'),(2,'Creado'),(3,'En proceso de revisión'),(4,'Revisado'),(5,'En proceso de aprobación'),(6,'Aprobado'),(7,'Vigente'),(8,'Obsoleto');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_campo`
--

LOCK TABLES `tipo_campo` WRITE;
/*!40000 ALTER TABLE `tipo_campo` DISABLE KEYS */;
INSERT INTO `tipo_campo` VALUES (1,'Texto'),(2,'Fecha'),(3,'Usuarios'),(5,'Tabulado'),(6,'Tipo'),(7,'Estado');
/*!40000 ALTER TABLE `tipo_campo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_campo_valor`
--

LOCK TABLES `tipo_campo_valor` WRITE;
/*!40000 ALTER TABLE `tipo_campo_valor` DISABLE KEYS */;
INSERT INTO `tipo_campo_valor` VALUES (1,7,1,'En proceso de edición'),(2,7,2,'Creado'),(3,7,3,'En proceso de revisión'),(4,7,4,'Revisado'),(5,7,5,'En proceso de aprobación'),(6,7,6,'Aprobado'),(7,7,7,'Vigente'),(8,7,8,'Obsoleto'),(16,6,1,'Procedimiento específico'),(17,6,2,'Procedimiento de apoyo'),(18,6,3,'Documento externo controlado'),(19,6,4,'Procedimiento operativo'),(20,6,5,'Manual de calidad'),(21,6,8,'Generales');
/*!40000 ALTER TABLE `tipo_campo_valor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_documento`
--

LOCK TABLES `tipo_documento` WRITE;
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` VALUES (1,'Procedimiento específico'),(2,'Procedimiento de apoyo'),(3,'Documento externo controlado'),(4,'Procedimiento operativo'),(5,'Manual de calidad'),(8,'Generales');
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;



DROP TABLE IF EXISTS `usuarios_alcance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_alcance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `alcance_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `alcance_id` (`alcance_id`),
  CONSTRAINT `usuarios_alcance_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `usuarios_alcance_ibfk_2` FOREIGN KEY (`alcance_id`) REFERENCES `alcances` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-09 13:15:25
