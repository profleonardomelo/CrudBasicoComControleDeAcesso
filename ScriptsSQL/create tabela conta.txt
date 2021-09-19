CREATE TABLE `bancoabc`.`conta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  `saldo` DOUBLE NOT NULL,
  `limite` DOUBLE NOT NULL,
  PRIMARY KEY (`id`));