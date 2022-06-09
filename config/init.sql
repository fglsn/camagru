-- Create DB --
create database if not exists `camagru_db`;

-- Create users table --
create table if not exists camagru_db.`users` (
		`user_id` int auto_increment primary key,
		`username` varchar(10) not null,
		`email` varchar(40) not null,
		`password` varchar(30) not null,
		`created_at` timestamp default current_timestamp on update current_timestamp
	);

