<?php
header('Content-Type: application/json');
$post_data = array(
  'item' => array(
    'item_type_id' => "123",
    'string_key' => "key",
    'string_value' => "value",
    'string_extra' => "extra",
    'is_public' => "Y",
   'is_public_for_contacts' => "N"
  )
);

$myJSON = json_encode($post_data);

echo $myJSON;
 ?>
