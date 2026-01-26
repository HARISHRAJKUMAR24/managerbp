<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$sql = "
SELECT
  mi.id,
  mi.name,
  mi.description,
  mi.hsn_code, -- ✅ ADD THIS LINE
  mi.menu_id,
  mi.category_id,
  mi.food_type,
  mi.image,
  mi.stock_type,
  mi.stock_qty,
  mi.stock_unit,
  mi.halal,
  mi.customer_limit,
  mi.customer_limit_period,
  mi.created_at AS last_updated,
  mi.price AS price,
  mi.price AS original_price,
  0 AS order_count,
  0 AS rating,
  'Medium' AS spice_level,
  mi.active AS is_available,
  mi.active AS show_on_site,
  0 AS is_best_seller -- Added this for consistency
FROM menu_items mi
ORDER BY mi.created_at DESC
";

$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Ensure frontend never crashes */
foreach ($items as &$item) {
  $item['tags'] = [];
  // Ensure boolean values
  $item['is_available'] = (bool)$item['is_available'];
  $item['show_on_site'] = (bool)$item['show_on_site'];
  $item['is_best_seller'] = (bool)$item['is_best_seller'];
  $item['halal'] = (bool)$item['halal'];
}

echo json_encode($items);