create table esliwo.elsie_credentials
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    cookie     text            null,
    email      varchar(255)    not null,
    passwd     varchar(255)    not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint elsie_credentials_user_id_foreign
        foreign key (user_id) references esliwo.users (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index elsie_credentials_email_index
    on esliwo.elsie_credentials (email);

create index elsie_credentials_passwd_index
    on esliwo.elsie_credentials (passwd);

