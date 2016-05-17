-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema vinareate
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema vinareate
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `vinareate` DEFAULT CHARACTER SET utf8 ;
USE `vinareate` ;

-- -----------------------------------------------------
-- Table `vinareate`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `email` VARCHAR(60) NOT NULL COMMENT 'Email is username',
  `password` VARCHAR(60) NOT NULL,
  `salt` VARCHAR(60) NOT NULL,
  `fullname` VARCHAR(60) NOT NULL,
  `avatar` VARCHAR(45) NULL,
  `gender` INT(1) NULL DEFAULT 0,
  `birthday` INT(10) NULL,
  `created` INT(10) NULL,
  `active` INT(1) NOT NULL DEFAULT 0,
  `status` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`permission` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`role` (
  `role` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`role`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`user_role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`province`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`province` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`district`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`district` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `province_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `province_id`),
  CONSTRAINT `fk_district_province`
    FOREIGN KEY (`id`)
    REFERENCES `vinareate`.`province` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`ward`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`ward` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `district_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `district_id`),
  INDEX `fk_ward_district1_idx` (`district_id` ASC),
  CONSTRAINT `fk_ward_district1`
    FOREIGN KEY (`district_id`)
    REFERENCES `vinareate`.`district` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`taxonomy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`taxonomy` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` VARCHAR(45) NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_keyword` VARCHAR(255) NULL,
  `meta_description` VARCHAR(255) NULL,
  `menu_order` INT(10) NOT NULL DEFAULT 0,
  `status` INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `slug` VARCHAR(255) NULL,
  `description` VARCHAR(255) NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_keyword` VARCHAR(255) NULL,
  `meta_description` VARCHAR(255) NULL,
  `parent` INT(11) NULL DEFAULT NULL,
  `status` INT(1) NOT NULL DEFAULT 1,
  `menu_order` INT(10) NULL DEFAULT 0,
  `taxonomy_id` INT NOT NULL,
  PRIMARY KEY (`id`, `taxonomy_id`),
  INDEX `fk_category_taxonomy1_idx` (`taxonomy_id` ASC),
  CONSTRAINT `fk_category_taxonomy1`
    FOREIGN KEY (`taxonomy_id`)
    REFERENCES `vinareate`.`taxonomy` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_status` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `excerpt` VARCHAR(255) NULL,
  `content` LONGTEXT NULL,
  `price` VARCHAR(255) NOT NULL,
  `price_installment` VARCHAR(255) NULL COMMENT '\ninstallment',
  `bed_rooms` INT(2) NULL,
  `bath_rooms` INT(2) NULL,
  `living_rooms` INT(2) NULL,
  `dining_rooms` INT(2) NULL,
  `office_rooms` INT(2) NULL,
  `worship_rooms` INT(2) NULL,
  `entertainment_rooms` INT(2) NULL,
  `balcony` INT(2) NULL,
  `floors` INT(2) NULL,
  `build_year` INT(10) NULL,
  `area_use` VARCHAR(45) NULL,
  `area_real` VARCHAR(45) NULL,
  `video` VARCHAR(255) NULL,
  `created` INT(10) NOT NULL,
  `modify_date` INT(10) NOT NULL,
  `publish_date` INT(10) NOT NULL,
  `menu_order` INT(10) NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `post_status_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `category_id`, `user_id`, `post_status_id`),
  INDEX `fk_post_category1_idx` (`category_id` ASC),
  INDEX `fk_post_user1_idx` (`user_id` ASC),
  INDEX `fk_post_post_status1_idx` (`post_status_id` ASC),
  CONSTRAINT `fk_post_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `vinareate`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `vinareate`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_post_status1`
    FOREIGN KEY (`post_status_id`)
    REFERENCES `vinareate`.`post_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_contact` (
  `id_contact` INT NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(255) NOT NULL,
  `conmany` VARCHAR(255) NULL,
  `email` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_contact`, `post_id`),
  INDEX `fk_post_contact_post1_idx` (`post_id` ASC),
  CONSTRAINT `fk_post_contact_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `vinareate`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_tax_history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_tax_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `area` VARCHAR(255) NULL COMMENT 'Diện tích',
  `year` INT(5) NULL COMMENT 'năm đóng thuế',
  `price` VARCHAR(60) NULL COMMENT 'Số tiền đóng thuế',
  `post_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `post_id`),
  INDEX `fk_post_tax_history_post1_idx` (`post_id` ASC),
  CONSTRAINT `fk_post_tax_history_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `vinareate`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_image` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  `width` INT(10) NOT NULL,
  `height` INT(10) NOT NULL,
  `image_type` INT(1) NULL COMMENT '1: Bản đồ nhà\n2: Ảnh đại diện\n3: gallery',
  `post_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `post_id`),
  INDEX `fk_post_image_post1_idx` (`post_id` ASC),
  CONSTRAINT `fk_post_image_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `vinareate`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_features`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_features` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NULL,
  `description` VARCHAR(60) NULL,
  `menu_order` INT(10) NULL,
  `parent` INT(11) NULL,
  `status` INT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vinareate`.`post_feature_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vinareate`.`post_feature_detail` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` INT UNSIGNED NOT NULL,
  `post_features_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `post_id`, `post_features_id`),
  INDEX `fk_post_feature_detail_post1_idx` (`post_id` ASC),
  INDEX `fk_post_feature_detail_post_features1_idx` (`post_features_id` ASC),
  CONSTRAINT `fk_post_feature_detail_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `vinareate`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_feature_detail_post_features1`
    FOREIGN KEY (`post_features_id`)
    REFERENCES `vinareate`.`post_features` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
