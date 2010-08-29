alter table user change  `user_id`  `id` int(11) NOT NULL auto_increment;
alter table user drop block_id;
alter table user drop column_id;
alter table user drop order_id;
alter table user add status int(11) NOT NULL default '0';