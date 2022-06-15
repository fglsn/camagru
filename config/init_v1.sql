-- Create DB --
create database if not exists camagru_db;

-- Create users table --
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

-- Create unique indexes to store only unique username and email, handle pdo-exeption errors in register.php --
create unique index username_index on camagru_db.users (username);
create unique index email_index on camagru_db.users (email);
create unique index activation_code_index on camagru_db.users (activation_code);

-- Create unique indexes to store only unique username and email, handle pdo-exeption errors in register.php --
create table if not exists camagru_db.password_reset_request (
		id int(10) unsigned not null auto_increment primary key,
		user_id int(10) unsigned not null,
		requested_at datetime not null,
		token varchar(255) collate utf8_unicode_ci not null
);

-- Create migrations to check if db is expected state --
create table if not exists camagru_db.migrations (
	mid int primary key
);

insert ignore into camagru_db.migrations (mid) values (1);