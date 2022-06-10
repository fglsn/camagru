-- Create DB --
create database if not exists camagru_db;

-- Create users table --
create table if not exists camagru_db.users (
		user_id int auto_increment primary key,
		username varchar(100) not null,
		email varchar(100) not null,
		password text not null,
		created_at timestamp default current_timestamp on update current_timestamp
	);

-- Create unique indexes to store only unique username and email, handle pdo-exeption errors in register.php --
create unique index username_index on camagru_db.users (username);
create unique index email_index on camagru_db.users (email);