use utangapp;

alter table transactions add Status enum('active', 'deleted') not null default 'active';
alter table notifications modify Type enum('friend_request', 'rejected', 'friend', 'added_transaction', 'deleted_transaction') not null default 'added_transaction';
