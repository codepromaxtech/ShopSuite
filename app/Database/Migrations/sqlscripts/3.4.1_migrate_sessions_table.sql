DROP TABLE IF EXISTS `shopsuite_sessions`;
CREATE TABLE IF NOT EXISTS `shopsuite_sessions` (
    `id` varchar(128) NOT null,
    `ip_address` varchar(45) NOT null,
    `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP NOT null,
    `data` blob NOT null,
    KEY `shopsuite_sessions_timestamp` (`timestamp`)
);

ALTER TABLE shopsuite_sessions ADD PRIMARY KEY (id, ip_address);
