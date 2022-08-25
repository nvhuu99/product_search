drop index idx_prod_name on product;
create fulltext index idx_prod_name on product (name);

drop index idx_category_id on product;
create index idx_category_id on product (category_id);

drop index idx_popular_id on product_sort;
create index idx_popular_id on product_sort (popular_id);

drop index idx_best_seller_id on product_sort;
create index idx_best_seller_id on product_sort (best_seller_id);

drop index idx_high_price_id on product_sort;
create index idx_high_price_id on product_sort (high_price_id);

drop index idx_low_price_id on product_sort;
create index idx_low_price_id on product_sort (low_price_id);

