-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: centro_asia_cri
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_utenti`
--

CREATE DATABASE IF NOT EXISTS centro_asia_cri
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE centro_asia_cri;

DROP TABLE IF EXISTS `admin_utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_utenti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nome_visualizzato` varchar(150) DEFAULT NULL,
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_utenti`
--

LOCK TABLES `admin_utenti` WRITE;
/*!40000 ALTER TABLE `admin_utenti` DISABLE KEYS */;
INSERT INTO `admin_utenti` VALUES (1,'admin','$2b$10$Qbt4pBqEkVSW6flf58dPK.pCrwspR2Xe3/wSNDSZcBEwiLx8SXDYe','Amministratore CRI Alcamo','2026-07-08 20:37:26');
/*!40000 ALTER TABLE `admin_utenti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attivita`
--

DROP TABLE IF EXISTS `attivita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attivita` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `responsabile` varchar(150) DEFAULT NULL,
  `note_interne` varchar(255) DEFAULT NULL COMMENT 'Note visibili solo in admin (es. "data da destinarsi")',
  `data_attivita` date DEFAULT NULL COMMENT 'NULL se data ancora da definire',
  `ora_inizio` time DEFAULT NULL,
  `ora_fine` time DEFAULT NULL,
  `posti_max` smallint(5) unsigned NOT NULL DEFAULT 20,
  `partecipazione_libera` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = nessun limite di posti / accesso libero',
  `quota_da_definire` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = quota torneo ancora da definire',
  `data_da_definire` tinyint(1) NOT NULL DEFAULT 0,
  `attiva` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Se 0, non visibile/iscrivibile sul sito pubblico',
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato_il` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_data` (`data_attivita`),
  KEY `idx_attiva` (`attiva`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attivita`
--

LOCK TABLES `attivita` WRITE;
/*!40000 ALTER TABLE `attivita` DISABLE KEYS */;
INSERT INTO `attivita` VALUES (1,'Alla scoperta di: Biologia e Zoologia marina - Campioni','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-07-01','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(2,'Fare Arte',NULL,'Mariangela Mannino',NULL,'2026-07-03','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(3,'Laboratorio di danza - scopriamo il mondo','Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente.','Carla Ferro',NULL,'2026-07-07','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(4,'Alla scoperta di: Biologia e Zoologia marina - La sabbia','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-07-08','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(5,'Torneo di Burraco','Partecipazione libera. Quota di iscrizione: da definire.',NULL,'Data rimandata, da destinarsi',NULL,NULL,NULL,9999,1,1,1,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(6,'Cuntami lu cuntu',NULL,NULL,NULL,'2026-07-13',NULL,NULL,20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(7,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,NULL,'2026-07-14','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(8,'Alla scoperta di: Biologia e Zoologia marina - L\'acqua di mare','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-07-15','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(9,'Fare Arte',NULL,'Mariangela Mannino',NULL,'2026-07-17','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(10,'Thai Chi','Accesso libero, senza limiti di partecipazione.','Rami Salo',NULL,'2026-07-17','19:00:00','20:00:00',9999,1,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(11,'Laboratorio di danza - scopriamo il mondo','Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente.','Carla Ferro',NULL,'2026-07-21','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(12,'Giochi senza Frontiere',NULL,NULL,NULL,'2026-07-27',NULL,NULL,20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(13,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,NULL,'2026-07-28','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(14,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,'Sessione aggiuntiva','2026-07-29','17:00:00','18:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(15,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,'Sessione aggiuntiva','2026-07-29','18:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(16,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,'Sessione aggiuntiva','2026-07-30','17:00:00','18:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(17,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,'Sessione aggiuntiva','2026-07-30','18:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(18,'Fare Arte',NULL,'Mariangela Mannino',NULL,'2026-07-31','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(19,'Thai Chi','Accesso libero, senza limiti di partecipazione.','Rami Salo',NULL,'2026-07-31','19:00:00','20:00:00',9999,1,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(20,'Torneo Calcio Balilla','Partecipazione libera. Quota di iscrizione: da definire.',NULL,NULL,'2026-08-01','16:00:00','19:00:00',9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(21,'Torneo Calcio Balilla','Partecipazione libera. Quota di iscrizione: da definire.',NULL,NULL,'2026-08-02','16:00:00','19:00:00',9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(22,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,NULL,'2026-08-04','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(23,'Beach Volley',NULL,NULL,'In attesa di specifiche dedicate','2026-08-05',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(24,'Beach Volley',NULL,NULL,'In attesa di specifiche dedicate','2026-08-06',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(25,'Beach Volley',NULL,NULL,'In attesa di specifiche dedicate','2026-08-07',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(26,'Thai Chi','Accesso libero, senza limiti di partecipazione.','Rami Salo',NULL,'2026-08-07','19:00:00','20:00:00',9999,1,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(27,'Beach Volley',NULL,NULL,'In attesa di specifiche dedicate','2026-08-08',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(28,'Beach Volley',NULL,NULL,'In attesa di specifiche dedicate','2026-08-09',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(29,'Stelle da osservare',NULL,NULL,NULL,'2026-08-09','21:30:00','23:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(30,'Laboratorio di danza - scopriamo il mondo','Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente.','Carla Ferro',NULL,'2026-08-11','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(31,'Alla scoperta di: Biologia e Zoologia marina - Animali Vivi','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-08-12','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(32,'Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale per favorire benessere, relazione e rilassamento in gruppo.',NULL,NULL,'2026-08-18','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(33,'Alla scoperta di: Biologia e Zoologia marina - Fanerogame (piante) e alghe','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-08-19','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(34,'Fare Arte',NULL,'Mariangela Mannino',NULL,'2026-08-21','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(35,'Thai Chi','Accesso libero, senza limiti di partecipazione.','Rami Salo',NULL,'2026-08-21','19:00:00','20:00:00',9999,1,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(36,'Beach Soccer',NULL,NULL,'In attesa di specifiche dedicate','2026-08-22',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(37,'Beach Soccer',NULL,NULL,'In attesa di specifiche dedicate','2026-08-23',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(38,'Beach Soccer',NULL,NULL,'In attesa di specifiche dedicate','2026-08-24',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(39,'Beach Soccer',NULL,NULL,'In attesa di specifiche dedicate','2026-08-25',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(40,'Alla scoperta di: Biologia e Zoologia marina - L\'anatomia dei pesci','Percorso di scoperta del mare e della costa con osservazioni, campioni e attività pratiche guidate da un esperto.','Mariano Dara',NULL,'2026-08-26','16:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(41,'Beach Soccer',NULL,NULL,'In attesa di specifiche dedicate','2026-08-27',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:48:14'),(42,'Laboratorio di danza - scopriamo il mondo','Laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività in un ambiente accogliente.','Carla Ferro',NULL,'2026-09-01','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(43,'Fare Arte',NULL,'Mariangela Mannino',NULL,'2026-09-04','17:00:00','19:00:00',20,0,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(44,'Torneo di Bocce','Partecipazione libera. Quota di iscrizione: da definire.',NULL,NULL,'2026-09-05',NULL,NULL,9999,1,1,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26'),(45,'Thai Chi','Accesso libero, senza limiti di partecipazione.','Rami Salo',NULL,'2026-09-11','19:00:00','20:00:00',9999,1,0,0,1,'2026-07-08 20:37:26','2026-07-08 20:37:26');
/*!40000 ALTER TABLE `attivita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenuti_sito`
--

DROP TABLE IF EXISTS `contenuti_sito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contenuti_sito` (
  `chiave` varchar(80) NOT NULL,
  `titolo` varchar(255) DEFAULT NULL COMMENT 'Etichetta visibile in amministrazione',
  `contenuto` text NOT NULL,
  `aggiornato_il` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`chiave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenuti_sito`
--

LOCK TABLES `contenuti_sito` WRITE;
/*!40000 ALTER TABLE `contenuti_sito` DISABLE KEYS */;
INSERT INTO `contenuti_sito` VALUES ('calendario_avviso','Calendario — Avviso iscrizioni','La partecipazione alle attività è gratuita, salvo diversa indicazione per i tornei (quota da definire). Ogni partecipante deve provvedere autonomamente ad acqua, snack e a tutto ciò che può servire durante l\'attività. Per l\'utilizzo della palestra è obbligatorio il certificato medico agonistico in corso di validità. Se hai esigenze o bisogni particolari, segnalali nel campo note del modulo di iscrizione: ne terremo conto.','2026-07-08 20:37:26'),('calendario_intro','Calendario — Introduzione','Scegli l\'attività che preferisci e iscriviti online: pochi dati, nessuna registrazione complicata. Per i corsi i posti sono limitati a 20 partecipanti; per Taichi e tornei la partecipazione è libera.','2026-07-08 20:37:26'),('corsi_intro','Corsi — Introduzione','Oltre alle attività sportive, il Centro Asia propone laboratori creativi e corsi di scoperta. Per ciascun corso il numero massimo di partecipanti è di 20 persone: conviene iscriversi in anticipo dal calendario.','2026-07-08 20:37:26'),('corso_biologia','Corso — Biologia marina','Un percorso di scoperta del mare e della costa: sabbia, acqua, campioni naturali e osservazione degli organismi che abitano l\'ambiente marino. Le lezioni combinano spiegazioni chiare e attività pratiche guidate da un esperto, per avvicinarsi al mondo della biologia e zoologia marina con curiosità e rispetto.','2026-07-08 20:37:26'),('corso_danza','Corso — Danza','Un laboratorio di movimento e espressione corporea per scoprire ritmo, coordinazione e creatività. Attraverso esercizi semplici e giochi di gruppo si impara a muoversi con naturalezza, ascoltando la musica e il proprio corpo in un ambiente accogliente e inclusivo.','2026-07-08 20:37:26'),('corso_musicoterapia','Corso — Musicoterapia','Sessioni di ascolto attivo e partecipazione musicale pensate per favorire benessere, relazione e rilassamento in gruppo. La musica diventa strumento di comunicazione e condivisione, adatta a ogni età e senza bisogno di esperienza precedente.','2026-07-08 20:37:26'),('palestra_certificato','Palestra — Certificato medico agonistico','Per accedere e utilizzare la palestra è obbligatorio essere in possesso del certificato medico agonistico in corso di validità. Presentalo al personale al primo accesso o quando richiesto.','2026-07-08 20:37:26'),('palestra_intro','Palestra — Introduzione','La sala attrezzi della palestra del Centro Asia è a disposizione per allenamento autonomo e attività guidate. Gli spazi sono organizzati per un utilizzo sicuro e confortevole, con attrezzature per il lavoro su forza, resistenza e mobilità.','2026-07-08 20:37:26'),('palestra_trainer','Palestra — Personal trainer','È possibile incontrare il personal trainer per un orientamento personalizzato, consigli sull\'uso degli attrezzi e supporto durante l\'allenamento. Chiedi in segreteria come fissare un appuntamento.','2026-07-08 20:37:26'),('servizio_testo','Pagina Il servizio','Testo in attesa di inserimento. La descrizione completa del servizio verrà pubblicata qui non appena disponibile.\n\n[Inserire qui il testo fornito da papà Romeo Echo con la presentazione del Centro Asia, dei servizi offerti, degli orari, dei contatti e ogni altra informazione utile per chi desidera conoscere l\'iniziativa.]','2026-07-08 20:37:26'),('taichi','Taichi','Le sessioni di Taichi (Thai Chi) sono aperte a tutti: l\'accesso è libero e non ci sono limiti di partecipazione. Puoi unirti quando preferisci, senza preoccuparti di esaurire i posti. Consulta il calendario qui sotto per le date e gli orari previsti.','2026-07-08 20:37:26'),('tornei_intro','Tornei — Introduzione','Durante l\'estate sono previsti tornei e gare amatoriali: Burraco, Calcio Balilla, Bocce e altre iniziative. Anche per i tornei non ci sono limiti di partecipazione: tutti possono iscriversi o partecipare secondo le modalità indicate per ciascuna gara.','2026-07-08 20:37:26'),('tornei_quota','Tornei — Quota di partecipazione','La quota di partecipazione ai tornei non è ancora definita e verrà comunicata successivamente. Torna a consultare questa pagina per gli aggiornamenti.','2026-07-08 20:37:26');
/*!40000 ALTER TABLE `contenuti_sito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iscrizioni`
--

DROP TABLE IF EXISTS `iscrizioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iscrizioni` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attivita_id` int(10) unsigned NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `eta` tinyint(3) unsigned NOT NULL,
  `note` varchar(500) DEFAULT NULL COMMENT 'Bisogni/esigenze particolari indicati dal partecipante',
  `iscritto_il` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_attivita` (`attivita_id`),
  CONSTRAINT `fk_iscrizioni_attivita` FOREIGN KEY (`attivita_id`) REFERENCES `attivita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iscrizioni`
--

LOCK TABLES `iscrizioni` WRITE;
/*!40000 ALTER TABLE `iscrizioni` DISABLE KEYS */;
/*!40000 ALTER TABLE `iscrizioni` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-08 22:50:18
