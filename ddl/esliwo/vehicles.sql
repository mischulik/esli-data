create table esliwo.vehicles
(
    id         bigint unsigned auto_increment
        primary key,
    name       text         not null,
    code       varchar(255) null,
    year_start int unsigned not null,
    year_end   int unsigned null,
    bodytypes  longtext     null,
    full_name  longtext     null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index vehicles_code_index
    on esliwo.vehicles (code);

create index vehicles_year_end_index
    on esliwo.vehicles (year_end);

create index vehicles_year_start_index
    on esliwo.vehicles (year_start);

