DROP TABLE IF EXISTS `rcr1_resource_list`;
CREATE TABLE `rcr1_resource_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `resource_url` text COLLATE utf8_unicode_ci NOT NULL COMMENT '资源来源地址',
  `redir_url` text COLLATE utf8_unicode_ci NOT NULL COMMENT '资源重定向地址',
  `expired_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
