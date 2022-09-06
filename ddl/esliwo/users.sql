create table esliwo.users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    password          varchar(255) not null,
    remember_token    varchar(100) null,
    timezone          varchar(255) null,
    email_verified_at timestamp    null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

create index users_email_verified_at_index
    on esliwo.users (email_verified_at);

create index users_name_index
    on esliwo.users (name);

