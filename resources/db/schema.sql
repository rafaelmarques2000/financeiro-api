CREATE TABLE users (
                       id uuid primary key ,
                       username varchar(128) not null,
                       password varchar(256) not null,
                       showName varchar(128) not null,
                       active bool not null
);

ALTER TABLE users add COLUMN created_at timestamp default NOW();
ALTER TABLE users add COLUMN updated_at timestamp default NOW();
ALTER TABLE users add COLUMN deleted_at timestamp;

CREATE TABLE accounts(
                         id uuid primary key ,
                         description varchar(256) not null ,
                         create_at timestamp default now(),
                         updated_at timestamp default now(),
                         deleted_at timestamp not null
);

CREATE TABLE user_accounts (
                               user_id uuid not null,
                               account_id uuid not null,
                               foreign key (user_id) REFERENCES users (id),
                               foreign key (account_id) REFERENCES accounts (id)
)