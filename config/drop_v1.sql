drop database if exists camagru_db;

drop table if exists camagru_db.users;

drop unique index if exists username_index on camagru_db.users (username);
drop unique index if exists email_index on camagru_db.users (email);
drop unique index if exists activation_code_index on camagru_db.users (activation_code);

drop table if exists camagru_db.password_reset_request;

drop unique index if exists token_index on camagru_db.password_reset_request (token);

drop table if exists camagru_db.posts;

drop table if exists camagru_db.comments;

drop table if exists camagru_db.likes;

drop table if exists camagru_db.migrations;