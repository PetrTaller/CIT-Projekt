--THIS PROJECT WAS CREATED BY PETR TALLER--

GCC: This is a remake of the original site "GCC"made by me used for Quotes

this is what the datgabase looks like if it doesnt work:
"

create database WALogin;
use WALogin;

create table users (
    id int primary key auto_increment,
    username varchar(250),
    password varchar(250),
    profile_id int
);

create table quotes (
     id int primary key auto_increment, 
     author varchar(250), 
     content varchar(250) 
);

"
