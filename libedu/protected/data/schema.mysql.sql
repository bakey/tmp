CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

create table IF NOT EXISTS tbl_user_active(
uid int(11) references tbl_user(id) on delete cascade,
active_id varchar(255) not null,
create_time datetime not null,
primary key(`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8

create table tbl_profile(
uid int(11) references tbl_user(id) on delete cascade,
real_name varchar(255) not null,
avatar varchar(255) not null,
description text
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists tbl_class(
id int(11) not null auto_increment,
name varchar(255) not null,
grade int ,
description text,
PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists tbl_grade(
 `grade_index` integer not null ,
 `grade_name` varchar(255) not null,
  PRIMARY KEY('grade_index')
 )engine=innodb default charset=utf8;
    
 create table `tbl_publisher`(
   `id` int(11) not null auto_increment,
   `name` varchar(255) not null,
   `description` text,
   PRIMARY KEY(`id`)
)engine=InnoDB default charset=utf8;

create table if not exists tbl_subject(
	`id` int not null auto_increment primary key,
	`name` varchar(255) not null,
	`description` text
)engine=innodb default charset=utf8;

create table if not exists tbl_course_edition(
	`id` int(11) not null auto_increment primary key,
	`name` varchar(255) not null,
	`grade` int not null ,
	`subject` int not null references tbl_subject(id) on delete cascade,
	`description` text default null,
	`publisher` int not null references tbl_publisher(id) on delete cascade,
	`uploader` int references tbl_user(id) on delete cascade,
	`image` varchar(255) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists tbl_course(
id int(11) not null auto_increment primary key,
edition_id int(11) references tbl_course_edition(id) on delete cascade ,
grade int references tbl_grade(grade_index) on delete cascade,
school_id int references tbl_school(id) on delete cascade,
name varchar(255) ,
description text,
view_count int 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tbl_user_course(
user_id int(11) not null references tbl_user(id) on delete cascade ,
course_id int(11) not null references tbl_course(id) on delete cascade,
role tinyint not null,
start_time datetime not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists `tbl_item`(
id int(11) not null auto_increment primary key,
edition int not null references tbl_course_edition(id) on delete cascade,
edi_index int(11) not null,
content text,
level tinyint,
create_time datetime not null
)ENGINE=Innodb default charset=utf8;

create table if not exists `tbl_item_kp`(
`item` int not null references tbl_item(id) on delete cascade,
`knowledge_point` int not null references tbl_knowledge_point(id) on delete cascade
)engine=innodb default charset=utf8;


create table tbl_item_item(
parent int(11) not null references tbl_item(id) on delete cascade,
child int(11) not null references tbl_item(id) on delete cascade
)engine=innodb default charset=utf8;

create table if not exists `tbl_question` (
	`id` int not null auto_increment primary key,
	`owner` int not null references tbl_user(id) on delete cascade,
	`item` int not null references tbl_item(id) on delete cascade,
	`details` text not null,
	`create_time` datetime not null,
	`view_count` int default 0
)engine=innodb default charset=utf8;

create table if not exists `tbl_question_kp`(
	`question` int not null references tbl_question(id) on delete cascade,
	`knowledge_point` int not null references tbl_knowledge_point(id) on delete cascade
)engine=innodb default charset=utf8;

create table if not exists `tbl_answer` (
	`id` int not null auto_increment primary key,
	`owner` int not null references tbl_user(id) on delete cascade,
	`question_id` int not null references tbl_question(id) on delete cascade,
	`type` int not null,
	`details` text,
	`create_time` datetime
)engine=innodb default charset=utf8;

create table if not exists `tbl_news_feed`(
	`id` int not null auto_increment primary key,
	`publisher` int not null references tbl_user(id) on delete cascade,
	`receiver` int not null references tbl_user(id) on delete cascade,
	`type` tinyint not null ,
	`create_time` datetime default NULL,
	`resource_id` int ,
	`content` text not null
)engine=innodb default charset=utf8;

create table if not exists `tbl_problem`(
 `id` int not null auto_increment primary key,
 `subject` int not null references tbl_subject(id) on delete cascade,
 `school` int not null references tbl_school(id) on delete cascade,
 `type` int not null,
  `content` text not null,
  `source` varchar(255),
  `difficulty` tinyint,
  `create_time` datetime not null,
  `update_time` datetime not null,
  `reference_ans` text,
  `ans_explain` text,
  `use_count` INTEGER,
  `select_ans` text
  )engine=innodb default charset=utf8;
   

create table if not exists `tbl_task` (
	`id` int(11) NOT NULL AUTO_INCREMENT primary key,
	`item_id` int(11) not null references tbl_item(id) on delete cascade,
	`name` varchar(255) ,
	`create_time` datetime not null,
	`update_time` datetime not null,
	`last_time` time not null,
	`author` int references tbl_user(id) on delete cascade,
	`description` text,
	`status` tinyint ,
	`course` int 
)engine=innodb default charset=utf8;

create table if not exists tbl_task_problem(
 `task_id` int not null references tbl_task(id) on delete cascade,
 `problem_id` int not null references tbl_problem(id) on delete cascade,
 `problem_score` int not null 
 )engine=innodb default charset=utf8;
	
create table if not exists tbl_task_record(
`task` int not null references tbl_task(id) on delete cascade,
`accepter` int not null references tbl_user(id) on delete cascade,
`start_time` datetime not null ,
`end_time` datetime not null,
`score` int not null default 0,
`status` tinyint not null default 0
)engine=innodb default charset=utf8;

create table if not exists tbl_task_kp(
	`task` int not null references tbl_task(id) on delete cascade,
	`kp` int not null references tbl_knowledge_point(id) on delete cascade
)engine=innodb default charset=utf8;

create table if not exists tbl_school(
	`id` int(11) not null auto_increment primary key,
	`name` varchar(255) not null ,
	`description` varchar(255) not null
)engine=innodb default charset=utf8;

create table if not exists tbl_user_school(
 `user_id` int not null references tbl_user(id) on delete cascade,
 `school_id` int not null references tbl_school(id) on delete cascade,
 `school_unique_id` varchar(255) default null,
 `role` int not null,
 `join_time` datetime default null,
 `leave_time` datetime default null,
 PRIMARY KEY(`user_id`)
 )engine=innodb default charset=utf8;
 
 create table if not exists tbl_knowledge_point(
 `id` int(11) not null auto_increment primary key,
 `course_id` int ,  
 `name` varchar(255) not null,
 `level` int not null,
 `description` text
 )engine=innodb default charset=utf8;
 
 create table if not exists tbl_kp_level(
 `parent` int not null references tbl_knowledge_point(id) on delete cascade,
 `child` int not null references tbl_knowledge_point(id) on delete cascade
 )engine=innodb default charset=utf8;
	
create table if not exists tbl_course_post(
	`id` int not null auto_increment primary key,
	`post` text not null,
	`author` int not null references tbl_user(id) on delete cascade,
	`item_id` int not null references tbl_item(id) on delete cascade,
	`status` tinyint not null,
	`create_time` datetime not null,
	`update_time` datetime not null
)engine=innodb default charset=utf8;
	
create table tbl_notification (
  `id` int auto_increment primary key,
  `publisher` int not null references tbl_user(id) on delete cascade,
  `receiver` int not null references tbl_user(id) on delete cascade,
  `type` tinyint not null,
  `create_time` datetime not null,
  `resource_id` int not null,
  `content` text
)engine=innodb default charset=utf8;
	
	
create table if not exists tbl_news(
	`id` int auto_increment primary key,
	`user` int not null references tbl_user(id) on delete cascade,
	`type` tinyint not null,
	`resource_id` int not null,
	`content` text not null,
	`create_time` datetime not null,
	`school` int not null references tbl_school(id) on delete cascade
)engine=innodb default charset=utf8;

create table if not exists tbl_problem_kp(
	`problem_id` int not null references tbl_problem(id) on delete cascade,
	`knowledge_point` int not null references tbl_knowledge_point(id) on delete cascade
)engine=innodb default charset=utf8;
	
create table if not exists tbl_user_class (
	`student_id` int not null references tbl_user(id) on delete cascade,
	`teacher_id` int not null references tbl_user(id) on delete cascade,
	`class_id` int not null references tbl_class(id) on delete cascade,
	start_time datetime not null 
)engine=innodb default charset=utf8;
	
create table if not exists tbl_teacher_item_trace (
	`teacher` int not null references tbl_user(id) on delete cascade,
	`item` int not null references tbl_item(id) on delete cascade
)engine=innodb default charset=utf8;

create table if not exists tbl_item_trace(
	`item` int not null references tbl_item(id) on delete cascade,
	`sub_item` int not null references tbl_item(id) on delete cascade
)engine=innodb default charset=utf8;
	