-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema flatteredDoc
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema flatteredDoc
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `flatteredDoc` DEFAULT CHARACTER SET utf8 ;
USE `flatteredDoc` ;

-- -----------------------------------------------------
-- Table `flatteredDoc`.`UmfrageConfig`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flatteredDoc`.`UmfrageConfig` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `author` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flatteredDoc`.`UmfrageQuestions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flatteredDoc`.`UmfrageQuestions` (
  `um_id` INT NOT NULL,
  `q_id` INT NOT NULL,
  `q_content` TEXT(4095) NULL,
  `q_type` INT NULL,
  PRIMARY KEY (`um_id`, `q_id`),
  CONSTRAINT `um_id`
    FOREIGN KEY (`um_id`)
    REFERENCES `flatteredDoc`.`UmfrageConfig` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flatteredDoc`.`UmfrageAnsOption`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flatteredDoc`.`UmfrageAnsOption` (
  `um_id` INT NOT NULL,
  `q_id` INT NOT NULL,
  `a_id` INT NOT NULL,
  `content` VARCHAR(45) NULL,
  PRIMARY KEY (`um_id`, `q_id`, `a_id`),
  INDEX `q_id_idx` (`q_id` ASC),
  CONSTRAINT `um_q_id`
    FOREIGN KEY (`um_id`,`q_id`)
    REFERENCES `flatteredDoc`.`UmfrageQuestions` (`um_id`,`q_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flatteredDoc`.`UmfrageAns`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flatteredDoc`.`UmfrageAns` (
  `u_id` INT NOT NULL,
  `um_id` INT NOT NULL,
  `q_id` INT NOT NULL,
  `a_id` INT NOT NULL,
  `time` DATETIME NULL,
  PRIMARY KEY (`u_id`, `um_id`, `q_id`, `a_id`),
  INDEX `um_id_idx` (`um_id` ASC),
  INDEX `q_id_idx` (`q_id` ASC),
  INDEX `a_id_idx` (`a_id` ASC),
  CONSTRAINT `um_q_a_id`
    FOREIGN KEY (`um_id`,`q_id`,`a_id`)
    REFERENCES `flatteredDoc`.`UmfrageAnsOption` (`um_id`,`q_id`,`a_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `flatteredDoc`.`UmfrageAnsText`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `flatteredDoc`.`UmfrageAnsText` (
  `u_id` INT NOT NULL,
  `um_id` INT NOT NULL,
  `q_id` INT NOT NULL,
  `content` TEXT(4095) NULL,
  `time` DATETIME NULL,
  PRIMARY KEY (`u_id`, `um_id`, `q_id`),
  INDEX `um_id_idx` (`um_id` ASC),
  INDEX `q_id_idx` (`q_id` ASC),
  CONSTRAINT `um_q1_id`
    FOREIGN KEY (`um_id`,`q_id`)
    REFERENCES `flatteredDoc`.`UmfrageQuestions` (`um_id`,`q_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
