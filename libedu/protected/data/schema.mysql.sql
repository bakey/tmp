CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf-8

create table tbl_user_active(
uid int(11) references tbl_user(id) on delete cascade,
active_id varchar(255) not null,
create_time datetime not null
);

create table tbl_profile(
uid int(11) references tbl_user(id) on delete cascade,
real_name varchar(255) not null,
avatar varchar(255) not null,
description text
);

create table tbl_class(
id int(11) not null auto_increment,
name varchar(255) not null,
grade int ,
description text,
PRIMARY KEY(`id`)
);

create table tbl_course_edition(
id int(11) not null auto_increment primary key,
name varchar(255) not null,
description text
);

create table tbl_course(
id int(11) not null auto_increment primary key,
edition_id int(11) references tbl_course_edition(id) on delete cascade ,
name varchar(255) ,
description text,
view_count int 
);

create table tbl_user_course(
user_id int(11) not null references tbl_user(id) on delete cascade ,
course_id int(11) not null references tbl_course(id) on delete cascade,
role tinyint not null,
start_time datetime not null
);
