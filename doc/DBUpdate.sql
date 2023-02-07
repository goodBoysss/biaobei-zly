-- 添加批量最大生成字段-by grq / 20200629
ALTER TABLE `lyx_api_authorize` ADD COLUMN `batch_num` int(6) DEFAULT 0 COMMENT '批量生成单次最大数' AFTER `rate_month`;

ALTER TABLE lyx_urls_u_*` CHANGE COLUMN `url` `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;