create table esliwo.websockets_statistics_entries
(
    id                      int unsigned auto_increment
        primary key,
    app_id                  varchar(255) not null,
    peak_connection_count   int          not null,
    websocket_message_count int          not null,
    api_message_count       int          not null,
    created_at              timestamp    null,
    updated_at              timestamp    null
)
    collate = utf8mb4_unicode_ci;

