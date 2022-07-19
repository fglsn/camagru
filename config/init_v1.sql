-- Create DB --
create database if not exists camagru_db;

-- Users table --
create table if not exists camagru_db.users (
	user_id int auto_increment primary key,
	username varchar(10) not null,
	email varchar(100) not null,
	password text not null,
	active tinyint not null default 0,
	activation_code text not null,
	activated_at datetime default null,
	notifications tinyint not null default 1,
	created_at timestamp not null default current_timestamp(),
	updated_at datetime default current_timestamp() on update current_timestamp()
);

-- Create unique indexes to store only unique username and email, handle pdo-exeption errors in signup.php --
create unique index username_index on camagru_db.users (username);
create unique index email_index on camagru_db.users (email);
create unique index activation_code_index on camagru_db.users (activation_code);


-- Password reset request table --
create table if not exists camagru_db.password_reset_request (
	id int not null auto_increment primary key,
	user_id int not null,
	requested_at datetime not null,
	token varchar(255) collate utf8_unicode_ci not null,
	foreign key (user_id)
		references camagru_db.users (user_id)
		on delete cascade
);

-- Create unique index to store only unique tokens, handle pdo-exeption errors in reset_pwp.php --
create unique index token_index on camagru_db.password_reset_request (token);


-- Posts table --
create table if not exists camagru_db.posts (
	post_id int auto_increment primary key,
	owner_id int not null,
	-- picture mediumblob not null,
	picture_path text not null,
	picture_description varchar(250) not null,
	created_at timestamp not null default current_timestamp(),
	webcam tinyint not null default 0,
	foreign key (owner_id)
		references camagru_db.users (user_id)
		on delete cascade
);

-- Comment table --
create table if not exists camagru_db.comments (
	comment_id int auto_increment primary key,
	post_id int not null,
	post_owner_id int not null,
	comment varchar(250) not null,
	commentator_id int not null,
	created_at timestamp not null default current_timestamp(),
	foreign key (post_id)
		references camagru_db.posts (post_id)
		on delete cascade,
	foreign key (post_owner_id)
		references camagru_db.users (user_id)
		on delete cascade,
	foreign key (commentator_id)
		references camagru_db.users (user_id)
		on delete cascade
);

-- Likes table --
create table if not exists camagru_db.likes (
	like_id	int auto_increment primary key,
	post_id int not null,
	user_id int not null,
	unique key post_and_user_unique (post_id, user_id),
	foreign key (post_id)
		references camagru_db.posts (post_id)
		on delete cascade,
	foreign key (user_id)
		references camagru_db.users (user_id)
		on delete cascade 
);

-- Create migrations to check if db is expected state --
create table if not exists camagru_db.migrations (
	mid int primary key
);

insert ignore into camagru_db.migrations (mid) values (1);