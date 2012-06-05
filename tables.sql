create table Users (
	user_id int NOT NULL auto_increment PRIMARY KEY,
	name varchar(30) not null unique,
	passwd varchar(32) not null,
	full_name varchar(30) not null,
	email varchar(15) not null
)
CHARACTER SET utf8 COLLATE utf8_general_ci;

create table Categories (
	cat_id int not null auto_increment primary key,
	name varchar(15) not null unique
)
CHARACTER SET utf8 COLLATE utf8_general_ci;  

create table Adv (
	adv_id int not null auto_increment PRIMARY KEY,
	user_id int not null,
	name varchar(30) not null,
	type int not null,
	caption varchar(30),
	text varchar(200),
	url varchar(50) not null,
	active boolean not null default '1',
	FOREIGN KEY (user_id) REFERENCES Users(user_id)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;  

create table Blocks (
	block_id int not null auto_increment PRIMARY KEY,
	user_id int not null,
	name varchar(30) not null,
	type int not null,
	subtype int,
	bgcolor varchar(7),
	txtcolor varchar(7),
	active boolean not null default '1',
	FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

create table Statistics (
	adv_id int not null,
	block_id int not null,
	views int default 0,
	clicks int default 0,

	PRIMARY KEY(adv_id, block_id),
	FOREIGN KEY(adv_id) REFERENCES Adv(adv_id),
	FOREIGN KEY(block_id) REFERENCES Blocks(block_id)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;  

create table Adv_Category(
	adv_id int not null,
	cat_id int not null,

	PRIMARY KEY(adv_id, cat_id),
	FOREIGN KEY(adv_id) REFERENCES Adv(adv_id),
	FOREIGN KEY(cat_id) REFERENCES Categories(cat_id)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;  

create table Block_Category(
	block_id int not null,
	cat_id int not null,

	PRIMARY KEY(block_id, cat_id),
	FOREIGN KEY(block_id) REFERENCES Blocks(block_id),
	FOREIGN KEY(cat_id) REFERENCES Categories(cat_id)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;