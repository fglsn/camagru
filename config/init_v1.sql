-- Create DB --
create database if not exists camagru_db;

-- Users table --
create table if not exists camagru_db.users (
		user_id int auto_increment primary key,
		username varchar(100) not null,
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
		id int(10) unsigned not null auto_increment primary key,
		user_id int(10) unsigned not null,
		requested_at datetime not null,
		token varchar(255) collate utf8_unicode_ci not null
);

-- Create unique index to store only unique tokens, handle pdo-exeption errors in reset_pwp.php --
create unique index token_index on camagru_db.password_reset_request (token);


-- Posts table --
create table if not exists camagru_db.posts (
	post_id int auto_increment primary key,
	owner_id int not null,
	-- picture mediumblob not null,
	picture_path text not null,
	picture_name varchar(50) not null,
	created_at timestamp not null default current_timestamp(),
	webcam tinyint not null default 0
);

-- Create migrations to check if db is expected state --
create table if not exists camagru_db.migrations (
	mid int primary key
);

insert ignore into camagru_db.migrations (mid) values (1);