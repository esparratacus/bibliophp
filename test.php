<?php

include_once dirname(__FILE__) . '/Database/credentials.php';
include_once dirname(__FILE__) . '/Database/MysqlAdapter.php';

$con= new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
$con->query("
CREATE TABLE `biblioteca`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NOT NULL,
    `email` VARCHAR(60) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `admin` INT NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("INSERT INTO users (username, email, password, admin) VALUES ('admin', 'admin@mail.com', '$2y$10$5Ov45Ce.Dq2PPd1APHjg3uLoMdTrhbHCmVPwYKGpRC/YfeZdZZX8O', 1);");

$con->query("
CREATE TABLE `biblioteca`.`books` (
    `id` INT NOT NULL AUTO_INCREMENT,
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
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `maker` VARCHAR(45) NOT NULL,
    `serial_number` VARCHAR(45) NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`events` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `starts_at` DATETIME NOT NULL,
    `ends_at` DATETIME NOT NULL,
    `location` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("
CREATE TABLE `biblioteca`.`rooms` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`));
");

$con->query("INSERT INTO rooms (name) VALUES ('sala_a');");
$con->query("INSERT INTO rooms (name) VALUES ('sala_b');");
$con->query("INSERT INTO rooms (name) VALUES ('sala_c');");
$con->query("INSERT INTO rooms (name) VALUES ('sala_d');");

$con->query("
CREATE TABLE `biblioteca`.`reservations` (
    `id` INT NOT NULL AUTO_INCREMENT,
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
  REFERENCES `biblioteca`.`users` (`id`)
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
    `id` INT NOT NULL AUTO_INCREMENT,
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
  REFERENCES `biblioteca`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
