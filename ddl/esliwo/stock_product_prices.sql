create table esliwo.stock_product_prices
(
    id               bigint unsigned auto_increment
        primary key,
    stock_product_id bigint unsigned               not null,
    price            bigint unsigned default 0     not null,
    currency         varchar(255)    default 'UAH' not null,
    created_at       timestamp                     null,
    updated_at       timestamp                     null,
    constraint stock_product_prices_stock_product_id_foreign
        foreign key (stock_product_id) references esliwo.stock_products (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index stock_product_prices_price_index
    on esliwo.stock_product_prices (price);

