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
  mi.menu_id,
  mi.category_id,
  mi.food_type,
  mi.image,
  mi.stock_type,
  mi.stock_qty,
  mi.stock_unit,
  mi.halal,
  mi.created_at AS last_updated,

  -- pricing
  mi.price AS price,
  mi.price AS original_price,

  -- UI defaults
  0 AS order_count,
  0 AS rating,
  'Medium' AS spice_level,
  mi.customer_limit,

  -- visibility
  mi.active AS is_available,
  mi.active AS show_on_site

FROM menu_items mi
ORDER BY mi.created_at DESC
";

$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Ensure frontend never crashes */
foreach ($items as &$item) {
  $item['tags'] = [];
  $item['is_best_seller'] = false;
}

echo json_encode($items);
