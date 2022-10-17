CREATE TABLE users (
                       id uuid primary key ,
                       username varchar(128) not null,
                       password varchar(256) not null,
                       show_name varchar(128) not null,
                       created_at timestamp default NOW(),
                       updated_at timestamp default NOW(),
                       deleted_at timestamp null,
                       active bool not null
);

ALTER TABLE users add COLUMN created_at timestamp default NOW();
ALTER TABLE users add COLUMN updated_at timestamp default NOW();
ALTER TABLE users add COLUMN deleted_at timestamp;

CREATE TABLE accounts(
                         id uuid primary key ,
                         description varchar(256) not null ,
                         account_type_id uuid not null ,
                         created_at timestamp default now(),
                         updated_at timestamp default now(),
                         deleted_at timestamp not null,
                         foreign key(account_type_id)  REFERENCES account_types(id)
);

CREATE TABLE user_accounts (
                               user_id uuid not null,
                               account_id uuid not null,
                               foreign key (user_id) REFERENCES users (id),
                               foreign key (account_id) REFERENCES accounts (id)
);

CREATE TABLE account_types (
                               id uuid primary key,
                               description varchar(120) not null,
                               slug_name varchar(100) unique,
                               created_at timestamp default NOW(),
                               updated_at timestamp default NOW()
);

ALTER TABLE accounts add column account_type_id uuid;
ALTER TABLE accounts add foreign key(account_type_id)  REFERENCES account_types(id);