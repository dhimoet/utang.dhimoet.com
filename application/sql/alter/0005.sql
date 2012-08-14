use utangapp;

alter table notifications modify Type enum('friend_request','added_transaction', 'friend', 'rejected') not null default 'added_transaction';
alter table userrelationships modify Type enum('friend','blocked','friend_request', 'rejected') not null default 'friend_request';
alter table notifications add Status enum('active', 'inactive') not null default 'active';
