CREATE TABLE `product` (
  `id` CHAR(10) NOT NULL PRIMARY KEY,
  `name` CHAR(255) NOT NULL,
  `brand` TEXT,
  `curency` CHAR(6),
  `symbol` CHAR (6),
  `retail_price` INT(11) NOT NULL DEFAULT '0',
  `selling_price` INT(11) NOT NULL DEFAULT '0',
  `discount_rate` INT(3) NOT NULL DEFAULT '0',
  `url` CHAR(255) DEFAULT '',
  `images` CHAR(255) DEFAULT '',
  `in_stock` BINARY
) ENGINE=InnoDB DEFAULT CHARSET=utf8;