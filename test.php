<?php

include_once dirname(__FILE__) . '/Database/credentials.php';
include_once dirname(__FILE__) . '/Database/MysqlAdapter.php';

$con= new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
$con->query("CREATE TABLE User(Id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(Id),FullName char(60),Email char(60),Password char(100),is_admin INT)");
$con->query("
CREATE TABLE `biblioteca`.`books` (
    `id` INT NOT NULL,
    `title` VARCHAR(45) NOT NULL,
    `author` VARCHAR(45) NOT NULL,
    `edition` VARCHAR(45) NOT NULL,
    `publisher` VARCHAR(45) NOT NULL,
    `isbn` VARCHAR(45) NOT NULL,
    `copies` INT NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`equipment` (
    `id` INT NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `maker` VARCHAR(45) NOT NULL,
    `serial_number` VARCHAR(45) NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`events` (
    `id` INT NOT NULL,
    `starts_at` DATETIME NOT NULL,
    `ends_at` DATETIME NOT NULL,
    `location` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`rooms` (
    `id` INT NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`reservations` (
    `id` INT NOT NULL,
    `user_id` INT NULL,
    `room_id` INT NULL,
    `reservation_starts` DATETIME NULL,
    `reservation_ends` DATETIME NULL,
    PRIMARY KEY (`id`));
");

$con->query("
ALTER TABLE `biblioteca`.`reservations` 
ADD CONSTRAINT `fk_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `biblioteca`.`User` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_room`
  FOREIGN KEY (`room_id`)
  REFERENCES `biblioteca`.`rooms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");

$con->query("
CREATE TABLE `biblioteca`.`reports` (
    `id` INT NOT NULL,
    `state` VARCHAR(45) NOT NULL,
    `comments` VARCHAR(512) NULL,
    `equipment_id` INT NULL,
    `user_id` INT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
ALTER TABLE `biblioteca`.`reports` 
ADD CONSTRAINT `fk_equipment`
  FOREIGN KEY (`equipment_id`)
  REFERENCES `biblioteca`.`equipment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_report`
  FOREIGN KEY (`user_id`)
  REFERENCES `biblioteca`.`User` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
