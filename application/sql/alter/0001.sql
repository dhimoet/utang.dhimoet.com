use utangapp;

alter table users_facebook modify UserID varchar(100);
alter table users_facebook modify Email varchar(100) not null unique;
alter table users modify email varchar(100) not null unique;
