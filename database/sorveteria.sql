-- MySQL Script generated by MySQL Workbench
-- Fri Jan 21 11:10:52 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sorveteria
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sorveteria
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sorveteria` DEFAULT CHARACTER SET utf8 ;
USE `sorveteria` ;

-- -----------------------------------------------------
-- Table `sorveteria`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sorveteria`.`cliente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `rua` VARCHAR(200) NOT NULL,
  `bairro` VARCHAR(200) NOT NULL,
  `telefone` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sorveteria`.`vendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sorveteria`.`vendas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valorTotal` FLOAT NOT NULL,
  `dataEHoraVenda` TIMESTAMP NOT NULL,
  `dataEHoraEntrega` TIMESTAMP NOT NULL,
  `tipoEntrega` VARCHAR(45) NOT NULL,
  `cliente_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vendas_cliente_idx` (`cliente_id` ASC) VISIBLE,
  CONSTRAINT `fk_vendas_cliente`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `sorveteria`.`cliente` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sorveteria`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sorveteria`.`produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `preco` FLOAT NOT NULL,
  `img` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sorveteria`.`produto_venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sorveteria`.`produto_venda` (
  `quantidade` INT NOT NULL,
  `preco` FLOAT NOT NULL,
  `produto_id` INT NOT NULL,
  `vendas_id` INT NOT NULL,
  INDEX `fk_produto_venda_produto1_idx` (`produto_id` ASC) VISIBLE,
  INDEX `fk_produto_venda_vendas1_idx` (`vendas_id` ASC) VISIBLE,
  CONSTRAINT `fk_produto_venda_produto1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `sorveteria`.`produto` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_venda_vendas1`
    FOREIGN KEY (`vendas_id`)
    REFERENCES `sorveteria`.`vendas` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
