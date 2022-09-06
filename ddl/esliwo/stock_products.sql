create table esliwo.stock_products
(
    id         bigint unsigned auto_increment
        primary key,
    stock_id   bigint unsigned not null,
    product_id bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint stock_products_stock_id_product_id_unique
        unique (stock_id, product_id),
    constraint stock_products_product_id_foreign
        foreign key (product_id) references esliwo.products (id)
            on delete cascade,
    constraint stock_products_stock_id_foreign
        foreign key (stock_id) references esliwo.stocks (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

