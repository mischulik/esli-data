create table esliwo.media
(
    id                    bigint unsigned auto_increment
        primary key,
    model_type            varchar(255)                 not null,
    model_id              bigint unsigned              not null,
    uuid                  char(36)                     null,
    collection_name       varchar(255)                 not null,
    name                  varchar(255)                 not null,
    file_name             varchar(255)                 not null,
    mime_type             varchar(255)                 null,
    disk                  varchar(255)                 not null,
    conversions_disk      varchar(255)                 null,
    size                  bigint unsigned              not null,
    manipulations         longtext collate utf8mb4_bin not null,
    custom_properties     longtext collate utf8mb4_bin not null,
    generated_conversions longtext collate utf8mb4_bin not null,
    responsive_images     longtext collate utf8mb4_bin not null,
    order_column          int unsigned                 null,
    created_at            timestamp                    null,
    updated_at            timestamp                    null,
    constraint media_uuid_unique
        unique (uuid),
    constraint custom_properties
        check (json_valid(`custom_properties`)),
    constraint generated_conversions
        check (json_valid(`generated_conversions`)),
    constraint manipulations
        check (json_valid(`manipulations`)),
    constraint responsive_images
        check (json_valid(`responsive_images`))
)
    collate = utf8mb4_unicode_ci;

create index media_model_type_model_id_index
    on esliwo.media (model_type, model_id);

create index media_order_column_index
    on esliwo.media (order_column);

