-- popular

DELIMITER $$
DROP FUNCTION IF EXISTS factor_rank_popular$$
CREATE FUNCTION factor_rank_popular(
	views INT, ratings INT, avg_rating INT, sales INT, recent_sales INT
) RETURNS INTEGER
BEGIN
	RETURN sales*(0.1) 
			+ recent_sales*(0.8) 
			+ views*(0.05) 
			+ ratings*(0.025) 
			+ avg_rating*(0.025);
END$$
DELIMITER ;

-- best_seller

DELIMITER $$
DROP FUNCTION IF EXISTS factor_rank_best_seller$$
CREATE FUNCTION factor_rank_best_seller(
	views INT, ratings INT, avg_rating INT, sales INT, recent_sales INT
) RETURNS INTEGER
BEGIN
	RETURN sales*(0.4) 
			+ recent_sales*(0.4) 
			+ views*(0.05) 
			+ ratings*(0.025) 
			+ avg_rating*(0.025);
END$$
DELIMITER ;