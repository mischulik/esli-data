create table esliwo.spammers
(
    id         bigint unsigned auto_increment
        primary key,
    ip_address varchar(255) not null,
    attempts   int          not null,
    blocked_at datetime     null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

