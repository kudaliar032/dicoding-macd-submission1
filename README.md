# GUEST BOOK

## How to Use

### without docker
1. composer install
2. copy .env.example to .env
3. edit .env
4. taraaa

### with docker-composer
1. composer install
2. copy .env.example to .env
3. edit .env
4. docker-composer up -d
5. tara

## Table
```
create table guest_book
(
    id    int not null
        constraint guest_book_pk
            primary key nonclustered,
    name  varchar(254),
    email varchar(254),
    phone varchar(254)
)
go

create unique index guest_book_id_uindex
    on guest_book (id)
go

```