SET NAMES utf8mb4 COLLATE utf8mb4_general_ci;

CREATE DATABASE IF NOT EXISTS planet DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
use planet;


CREATE TABLE IF NOT EXISTS `app_info` (
    `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `appID` VARCHAR(60)  NULL DEFAULT 'wx5734fab052c4d148',
    `appsecret` VARCHAR(60) NULL  DEFAULT 'f72346ca61abf08f16b07dae3b2410e9',
    `aesKey` VARCHAR(60) NULL DEFAULT 'hLNoD5nkMzI3HwipVR7wArAM9thz1MbNdDFwtolEwmk',
    `token` VARCHAR(60) NULL DEFAULT 'nGM5WxHeRWIXsOjCbAjm4Y',
    `url` VARCHAR(60) NULL  COMMENT 'URL(服务器地址)',
    `access_token` VARCHAR(60) NULL  DEFAULT '',
    `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
    `updated_at` timestamp DEFAULT '0000-00-00 00:00:00',
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX (`appID`),
    UNIQUE KEY (`appID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

insert into app_info (appID, appsecret, aesKey, token, url) values ('wx5734fab052c4d148', 'f72346ca61abf08f16b07dae3b2410e9', 'hLNoD5nkMzI3HwipVR7wArAM9thz1MbNdDFwtolEwmk', 'nGM5WxHeRWIXsOjCbAjm4Y', 'http://115.28.227.100/');
