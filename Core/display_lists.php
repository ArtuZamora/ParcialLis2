<?php
function existsRandom($number, $array)
{
    $length = count($array);
    for ($i = 0; $i < $length; $i++) {
        if ($array[$i] == $number)
            return true;
    }
    return false;
}

$length = count($products);
$numbers = array();
$length2 = $length >= 3 ? 3 : $length;
for ($i = 0; $i < $length2; $i++) {
    do {
        $rand = rand(0, $length - 1);
    } while (existsRandom($rand, $numbers));
    $numbers[$i] = $rand;
}
$filtered = array();
foreach ($products as $product) {
    if ($product["Stock"] != 0)
        $filtered[] = $product;
}
usort($filtered, function ($a, $b) {
    return (float)$a["Price"] - (float)$b["Price"];
});