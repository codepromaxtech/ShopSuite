
DROP TABLE `shopsuite_sessions`;

CREATE TABLE IF NOT EXISTS `shopsuite_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `data` blob NOT NULL,
    KEY `shopsuite_sessions_timestamp` (`timestamp`)
    );

ALTER TABLE shopsuite_sessions ADD PRIMARY KEY (id, ip_address);

UPDATE `shopsuite_app_config`
SET `value` = REPLACE(value, '|', ',')
WHERE `key` = 'image_allowed_types';

-- due to language rename, reset to english
UPDATE `shopsuite_app_config` SET `value` = 'en' WHERE `key` = 'language_code' ;
UPDATE `shopsuite_app_config` SET `value` = 'english' WHERE `key` = 'language' ;
