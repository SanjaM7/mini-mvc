ALTER TABLE `mini`.`songs`
ADD COLUMN `user_id` INT NOT NULL AFTER `link`,
ADD INDEX `fk_song_user_idx` (`user_id` ASC);
;
ALTER TABLE `mini`.`songs`
ADD CONSTRAINT `fk_song_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `mini`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

