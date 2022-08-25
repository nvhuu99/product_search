-- Sort popular

DELIMITER $$
DROP PROCEDURE IF EXISTS product_sort_popular$$
CREATE PROCEDURE product_sort_popular()
BEGIN

    SET @row_number = 0; 
    UPDATE product_sort
    JOIN (
        SELECT 
            A.product_id as product_id, 
            (@row_number:=@row_number + 1) AS product_rank
        FROM 
        (
            SELECT 
            product_id,
            factor_rank_popular(sales, recent_sales, views, ratings, avg_rating) as factor_rank 
            FROM product_factor
            ORDER BY factor_rank DESC
        ) A 
    ) product_popular_sort 
    ON product_sort.product_rank = product_popular_sort.product_rank
    SET product_sort.popular_id = product_popular_sort.product_id;

END$$
DELIMITER ;

-- Sort best seller

DELIMITER $$
DROP PROCEDURE IF EXISTS product_sort_best_seller$$
CREATE PROCEDURE product_sort_best_seller()
BEGIN

    SET @row_number = 0; 
    UPDATE product_sort
    JOIN (
        SELECT 
            A.product_id as product_id, 
            (@row_number:=@row_number + 1) AS product_rank
        FROM 
        (
            SELECT 
            product_id,
            factor_rank_best_seller(sales, recent_sales, views, ratings, avg_rating) as factor_rank 
            FROM product_factor
            ORDER BY factor_rank DESC
        ) A 
    ) product_best_seller_sort 
    ON product_sort.product_rank = product_best_seller_sort.product_rank
    SET product_sort.best_seller_id = product_best_seller_sort.product_id;

END$$
DELIMITER ;

-- Sort high price

DELIMITER $$
DROP PROCEDURE IF EXISTS product_sort_high_price$$
CREATE PROCEDURE product_sort_high_price()
BEGIN

    SET @row_number = 0; 
    UPDATE product_sort
    JOIN (
        SELECT 
            A.product_id as product_id, 
            (@row_number:=@row_number + 1) AS product_rank
        FROM 
        (
            SELECT 
            id as product_id,
            COALESCE(discount_price, unit_price) as price 
            FROM product
            ORDER BY price DESC
        ) A 
    ) product_high_price_sort 
    ON product_sort.product_rank = product_high_price_sort.product_rank
    SET product_sort.high_price_id = product_high_price_sort.product_id;

END$$
DELIMITER ;

-- low price

DELIMITER $$
DROP PROCEDURE IF EXISTS product_sort_low_price$$
CREATE PROCEDURE product_sort_low_price()
BEGIN

    SET @row_number = 0; 
    UPDATE product_sort
    JOIN (
        SELECT 
            A.product_id as product_id, 
            (@row_number:=@row_number + 1) AS product_rank
        FROM 
        (
            SELECT 
            id as product_id,
            COALESCE(discount_price, unit_price) as price 
            FROM product
            ORDER BY price ASC
        ) A 
    ) product_low_price_sort 
    ON product_sort.product_rank = product_low_price_sort.product_rank
    SET product_sort.low_price_id = product_low_price_sort.product_id;

END$$
DELIMITER ;