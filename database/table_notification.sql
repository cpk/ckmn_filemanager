DROP TABLE `notification`;
DROP TABLE `user_notification`;
CREATE TABLE  `notifications` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 `content` TEXT NULL ,
 `date_create` DATETIME NULL ,
 `user_create` INT NULL ,
 `type` VARCHAR( 50 ) NULL
) ENGINE = MYISAM ;
CREATE TABLE  `user_notifications` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 `user_id` INT NULL ,
 `notification_id` INT NULL
) ENGINE = MYISAM ;
