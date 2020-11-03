SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema exercise_looper
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `exercise_looper` ;

-- -----------------------------------------------------
-- Schema exercise_looper
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `exercise_looper` DEFAULT CHARACTER SET utf8 ;
USE `exercise_looper` ;

-- -----------------------------------------------------
-- Table `exercise_looper`.`exercises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercise_looper`.`exercises` ;

CREATE TABLE IF NOT EXISTS `exercise_looper`.`exercises` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(1000) NOT NULL,
  `state` ENUM('building', 'answering', 'closed') NOT NULL DEFAULT 'building',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercise_looper`.`questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercise_looper`.`questions` ;

CREATE TABLE IF NOT EXISTS `exercise_looper`.`questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(1000) NOT NULL,
  `type` ENUM("single_line", "single_line_list", "multi_line") NOT NULL,
  `exercises_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_questions_exercises_idx` (`exercises_id` ASC),
  CONSTRAINT `fk_questions_exercises`
    FOREIGN KEY (`exercises_id`)
    REFERENCES `exercise_looper`.`exercises` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercise_looper`.`fulfillments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercise_looper`.`fulfillments` ;

CREATE TABLE IF NOT EXISTS `exercise_looper`.`fulfillments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `timestamp` TIMESTAMP NOT NULL,
  `exercises_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fulfillements_exercises1_idx` (`exercises_id` ASC),
  CONSTRAINT `fk_fulfillements_exercises1`
    FOREIGN KEY (`exercises_id`)
    REFERENCES `exercise_looper`.`exercises` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercise_looper`.`responses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercise_looper`.`responses` ;

CREATE TABLE IF NOT EXISTS `exercise_looper`.`responses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(1000) NULL,
  `questions_id` INT NOT NULL,
  `fulfillments_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_responses_questions1_idx` (`questions_id` ASC),
  INDEX `fk_responses_fulfillements1_idx` (`fulfillments_id` ASC),
  CONSTRAINT `fk_responses_questions1`
    FOREIGN KEY (`questions_id`)
    REFERENCES `exercise_looper`.`questions` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responses_fulfillements1`
    FOREIGN KEY (`fulfillments_id`)
    REFERENCES `exercise_looper`.`fulfillments` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
