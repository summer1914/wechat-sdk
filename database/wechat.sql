SET NAMES utf8mb4 COLLATE utf8mb4_general_ci;

CREATE DATABASE IF NOT EXISTS planet DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
use planet;


CREATE TABLE IF NOT EXISTS `routes` (
    `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `feedbackId` SMALLINT UNSIGNED  NULL ,
    `sort` SMALLINT  NOT NULL  DEFAULT 0  COMMENT '排序',
    `needInsurance` TINYINT(1)  NOT NULL  DEFAULT 0  COMMENT '是否需要保险，0不需要，1需要',
    `needContract` TINYINT(1)  NOT NULL  DEFAULT 0  COMMENT '是否需要合同，0需要，1不需要',
    `stopTimeType` TINYINT(1)  NOT NULL  DEFAULT 1  COMMENT '截止报名类型，1前一天下午5点，2当天中午12点,3前一天下午3点',
    `catalog` VARCHAR(20) NOT NULL   DEFAULT 'TravelTime' COMMENT  '分类，如citywalk',
    `picture` VARCHAR(150) NULL DEFAULT NULL  COMMENT '列表页封面图',
    `hoverIntro` VARCHAR(150)  NULL DEFAULT NULL  COMMENT 'hover介绍',
    `heading` VARCHAR(150) NOT NULL  COMMENT '路线标题',
    `scheduleTitle` VARCHAR(60) NOT  NULL DEFAULT '行程介绍'  COMMENT '行程介绍标题',
    `highlightTitle` VARCHAR(60) NOT  NULL DEFAULT '行程亮点'  COMMENT '行程两点标题',
    `abbreviation` VARCHAR(60)  NULL  COMMENT '简称',
    `title` VARCHAR(60)  NULL  COMMENT '副标题',
    `saleTag` VARCHAR(60)  NULL  DEFAULT '抢购' COMMENT '二级列表页优惠tag名称，如促销',
    `city` VARCHAR(60)  NULL  COMMENT '城市',
    `cityBlock` VARCHAR(60)  NULL  COMMENT '城区',
    `director` SMALLINT  NULL  COMMENT '负责人' DEFAULT 0,
    `introTitle` VARCHAR(60)  NULL  COMMENT '简介标题',
    `sponsorTitle` VARCHAR(60)  NULL,
    `leaderGuide` VARCHAR(100)  NULL  ,
    `intro` TEXT  NULL DEFAULT NULL  COMMENT '简介',
    `attentions` TEXT  NULL DEFAULT NULL  COMMENT '注意事项',
    `feeIntro` TEXT  NULL DEFAULT NULL  COMMENT '费用介绍',
    `duration` float(3, 1)  NULL  COMMENT '持续时间',
    `endLocation` VARCHAR(150)   NULL  COMMENT '结束地点',
    `dailyPrice` float(10, 2)  NOT NULL  COMMENT '日常价',
    `todayPrice` float(10, 2)  NOT NULL  COMMENT '当天价格',
    `status` TINYINT(1)  NOT NULL DEFAULT 2  COMMENT '路线状态,1正常，2隐藏',
    `isStick` TINYINT(1)  NOT NULL DEFAULT 0,
    `size` VARCHAR(30) NULL  COMMENT '规模',
    `travelWay` VARCHAR(60) NULL  COMMENT '游览方式',
    `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
    `updated_at` timestamp DEFAULT '0000-00-00 00:00:00',
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX (`catalog`),
    INDEX (`city`),
    INDEX (`cityBlock`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
