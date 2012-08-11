use utangapp;

alter table notifications drop RelatedUserID;
alter table notifications add SenderId int(11) not null;
alter table notifications add ReceiverId int(11) not null;
alter table notifications add Viewed int(1) not null default 0;
