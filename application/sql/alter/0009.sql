use utangapp;

create table facebook_users ( session_id varchar(40) not null default 0, user_id varchar(100) not null primary key default 'NULL', token text not null);
