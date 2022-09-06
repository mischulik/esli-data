create table esliwo.stock_product_quantities
(
    id               bigint unsigned auto_increment
        primary key,
    stock_product_id bigint unsigned               not null,
    quantity         bigint unsigned default 0     not null,
    units            varchar(255)    default 'pcs' not null,
    created_at       timestamp                     null,
    updated_at       timestamp                     null,
    constraint stock_product_quantities_stock_product_id_foreign
        foreign key (stock_product_id) references esliwo.stock_products (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

