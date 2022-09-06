create table esliwo.stocks
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255)    not null,
    shop_id    bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint stocks_name_unique
        unique (name),
    constraint stocks_shop_id_unique
        unique (shop_id)
)
    collate = utf8mb4_unicode_ci;

