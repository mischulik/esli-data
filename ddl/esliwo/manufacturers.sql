create table esliwo.manufacturers
(
    id          bigint unsigned auto_increment
        primary key,
    code_suffix varchar(255) not null,
    name        varchar(255) null,
    country     varchar(255) null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    constraint manufacturers_code_suffix_unique
        unique (code_suffix)
)
    collate = utf8mb4_unicode_ci;

