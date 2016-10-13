-- MySQL Script generated by MySQL Workbench
-- Qui 13 Out 2016 15:38:30 BRT
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mbdsas_tlm
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mbdsas_tlm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mbdsas_tlm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mbdsas_tlm` ;

-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`repository`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`repository` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`repository` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `label` VARCHAR(100) NULL COMMENT '',
  `url` VARCHAR(100) NULL COMMENT '',
  `last_access` DATETIME NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`mlm`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`mlm` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`mlm` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `label` VARCHAR(100) NULL COMMENT '',
  `url` VARCHAR(100) NULL COMMENT '',
  `ip` VARCHAR(15) NULL COMMENT '',
  `mac` VARCHAR(20) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`md`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`md` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`md` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `chassis_id_subtype` VARCHAR(45) NULL COMMENT '',
  `chassis_id` VARCHAR(45) NULL COMMENT '',
  `port_id` VARCHAR(45) NULL COMMENT '',
  `port_id_subtype` VARCHAR(60) NULL COMMENT '',
  `port_desc` VARCHAR(100) NULL COMMENT '',
  `sys_name` VARCHAR(100) NULL COMMENT '',
  `sys_desc` TEXT NULL COMMENT '',
  `sys_cap_supported` VARCHAR(60) NULL COMMENT '',
  `sys_cap_enabled` VARCHAR(60) NULL COMMENT '',
  `man_addr_entry` VARCHAR(45) NULL COMMENT '',
  `connect_time` DATETIME NULL COMMENT '',
  `mlm_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_md_mlm1_idx` (`mlm_id` ASC)  COMMENT '',
  CONSTRAINT `fk_md_mlm1`
    FOREIGN KEY (`mlm_id`)
    REFERENCES `mbdsas_tlm`.`mlm` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`user` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` VARCHAR(50) NULL COMMENT '',
  `password` VARCHAR(50) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`language`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`language` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`language` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  `vendor` VARCHAR(45) NULL COMMENT '',
  `revision` VARCHAR(45) NULL COMMENT '',
  `descr` TEXT NULL COMMENT '',
  `last_updated` DATETIME NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`extension`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`extension` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`extension` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `extension` VARCHAR(45) NOT NULL COMMENT '',
  `version` VARCHAR(45) NULL COMMENT '',
  `vendor` VARCHAR(45) NULL COMMENT '',
  `revision` VARCHAR(45) NULL COMMENT '',
  `descr` TEXT NULL COMMENT '',
  `last_updated` DATETIME NULL COMMENT '',
  `id_language` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_extension_language1_idx` (`id_language` ASC)  COMMENT '',
  UNIQUE INDEX `extension_UNIQUE` (`extension` ASC)  COMMENT '',
  CONSTRAINT `fk_extension_language1`
    FOREIGN KEY (`id_language`)
    REFERENCES `mbdsas_tlm`.`language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`script`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`script` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`script` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `owner` VARCHAR(100) NULL COMMENT '',
  `name` VARCHAR(100) NOT NULL COMMENT '',
  `source` VARCHAR(255) NULL COMMENT '',
  `admin_status` VARCHAR(45) NULL COMMENT '',
  `oper_status` VARCHAR(45) NULL COMMENT '',
  `storage_type` VARCHAR(255) NULL COMMENT '',
  `row_status` VARCHAR(100) NULL COMMENT '',
  `error` VARCHAR(150) NULL COMMENT '',
  `last_updated` DATETIME NULL COMMENT '',
  `descr` TEXT NULL COMMENT '',
  `id_language` INT NOT NULL COMMENT '',
  `code_identifier` CHAR(32) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_script_language1_idx` (`id_language` ASC)  COMMENT '',
  UNIQUE INDEX `identifier_UNIQUE` (`code_identifier` ASC)  COMMENT '',
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)  COMMENT '',
  CONSTRAINT `fk_script_language1`
    FOREIGN KEY (`id_language`)
    REFERENCES `mbdsas_tlm`.`language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`mlm_language`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`mlm_language` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`mlm_language` (
  `id_mlm` INT NOT NULL COMMENT '',
  `id_language` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id_mlm`, `id_language`)  COMMENT '',
  INDEX `fk_mlm_has_language_language1_idx` (`id_language` ASC)  COMMENT '',
  INDEX `fk_mlm_has_language_mlm1_idx` (`id_mlm` ASC)  COMMENT '',
  CONSTRAINT `fk_mlm_has_language_mlm1`
    FOREIGN KEY (`id_mlm`)
    REFERENCES `mbdsas_tlm`.`mlm` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mlm_has_language_language1`
    FOREIGN KEY (`id_language`)
    REFERENCES `mbdsas_tlm`.`language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`md_filter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`md_filter` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`md_filter` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `attribute` VARCHAR(45) NULL COMMENT '',
  `value` VARCHAR(45) NULL COMMENT '',
  `operator` VARCHAR(45) NULL COMMENT '',
  `last_updated` DATETIME NULL COMMENT '',
  `id_script` INT NOT NULL COMMENT '',
  `identifier` CHAR(32) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_md_filter_script1_idx` (`id_script` ASC)  COMMENT '',
  UNIQUE INDEX `identifier_UNIQUE` (`identifier` ASC)  COMMENT '',
  CONSTRAINT `fk_md_filter_script1`
    FOREIGN KEY (`id_script`)
    REFERENCES `mbdsas_tlm`.`script` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`script_repository`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`script_repository` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`script_repository` (
  `script_id` INT NOT NULL COMMENT '',
  `repository_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`script_id`, `repository_id`)  COMMENT '',
  INDEX `fk_script_has_repository_repository1_idx` (`repository_id` ASC)  COMMENT '',
  INDEX `fk_script_has_repository_script1_idx` (`script_id` ASC)  COMMENT '',
  CONSTRAINT `fk_script_has_repository_script1`
    FOREIGN KEY (`script_id`)
    REFERENCES `mbdsas_tlm`.`script` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_script_has_repository_repository1`
    FOREIGN KEY (`repository_id`)
    REFERENCES `mbdsas_tlm`.`repository` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mbdsas_tlm`.`mlm_script`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mbdsas_tlm`.`mlm_script` ;

CREATE TABLE IF NOT EXISTS `mbdsas_tlm`.`mlm_script` (
  `mlm_id` INT NOT NULL COMMENT '',
  `script_id` INT NOT NULL COMMENT '',
  `index` INT NOT NULL COMMENT '',
  PRIMARY KEY (`mlm_id`, `script_id`)  COMMENT '',
  INDEX `fk_mlm_has_script_script1_idx` (`script_id` ASC)  COMMENT '',
  INDEX `fk_mlm_has_script_mlm1_idx` (`mlm_id` ASC)  COMMENT '',
  CONSTRAINT `fk_mlm_has_script_mlm1`
    FOREIGN KEY (`mlm_id`)
    REFERENCES `mbdsas_tlm`.`mlm` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mlm_has_script_script1`
    FOREIGN KEY (`script_id`)
    REFERENCES `mbdsas_tlm`.`script` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
