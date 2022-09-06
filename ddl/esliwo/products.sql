create table esliwo.products
(
    id              bigint unsigned auto_increment
        primary key,
    elsie_code      varchar(255)    not null,
    stock_code      varchar(255)    null,
    manufacturer_id bigint unsigned null,
    vehicle_id      bigint unsigned null,
    name            text            null,
    search_name     longtext        null,
    note            varchar(255)    null,
    size            varchar(255)    null,
    created_at      timestamp       null,
    updated_at      timestamp       null,
    constraint products_elsie_code_unique
        unique (elsie_code),
    constraint products_manufacturer_id_foreign
        foreign key (manufacturer_id) references esliwo.manufacturers (id)
            on delete cascade,
    constraint products_vehicle_id_foreign
        foreign key (vehicle_id) references esliwo.vehicles (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

