-- Stint22 database migration
-- Run this ONCE only if you already imported the older stint22.sql database.

USE `stint22`;

ALTER TABLE `user_info`
  ADD COLUMN `image` varchar(255) NOT NULL DEFAULT 'img/user.jpg' AFTER `category`,
  ADD COLUMN `date` date DEFAULT NULL AFTER `image`;

UPDATE `user_info`
SET `image` = 'img/user.jpg'
WHERE `image` IS NULL OR `image` = '';
