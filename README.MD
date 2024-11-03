--THIS PROJECT WAS CREATED BY PETR TALLER--

Kvout: This is a remake of the original site "GCC"made by me used for Quotes

this is what the datgabase looks like if it doesnt work:
"

create database Databs;
use Databs;

create table users (
    id int primary key auto_increment,
    username varchar(250),
    password varchar(250),
    profile_id int,
    is_admin BOOLEAN
);
create table blog_posts (
    id int primary key auto_increment, 
    content text not null,
    created_at datetime default current_timestamp,
    author varchar(250) not null,
    visibility varchar(250)
);
"
