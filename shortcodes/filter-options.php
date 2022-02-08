<?php
$priceHighLowArr = array ();
$opt1 = new stdClass; $opt1->value = "price_desc"; $opt1->name = "Price (High to Low)"; array_push($priceHighLowArr, $opt1);
$opt1 = new stdClass; $opt1->value = "price_asc"; $opt1->name = "Price (Low to High)"; array_push($priceHighLowArr, $opt1);
$opt1 = new stdClass; $opt1->value = "length_desc"; $opt1->name = "Length (High to Low)"; array_push($priceHighLowArr, $opt1);
$opt1 = new stdClass; $opt1->value = "length_asc"; $opt1->name = "Length (Low to High)"; array_push($priceHighLowArr, $opt1);
$opt1 = new stdClass; $opt1->value = "gvwr_desc"; $opt1->name = "GVWR (High to Low)"; array_push($priceHighLowArr, $opt1);
$opt1 = new stdClass; $opt1->value = "gvwr_asc"; $opt1->name = "GVWR (Low to High)"; array_push($priceHighLowArr, $opt1);

$priceRangeArr = array ();
$opt1 = new stdClass; $opt1->value = "0_5000"; $opt1->name = "$0 - $5,000"; array_push($priceRangeArr, $opt1);
$opt1 = new stdClass; $opt1->value = "5000_10000"; $opt1->name = "$5,000 - $10,000"; array_push($priceRangeArr, $opt1);
$opt1 = new stdClass; $opt1->value = "10000_15000"; $opt1->name = "$10,000 - $15,000"; array_push($priceRangeArr, $opt1);
$opt1 = new stdClass; $opt1->value = "15000"; $opt1->name = "$15,000 +"; array_push($priceRangeArr, $opt1);

/*$invLengthArr = array ();
$opt1 = new stdClass; $opt1->value = "240"; $opt1->name = "20'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "480"; $opt1->name = "40'"; array_push($invLengthArr, $opt1);
*/

$heightArr = array ();
$opt1 = new stdClass; $opt1->value = "94"; $opt1->name = "Standard Height"; array_push($heightArr, $opt1);
$opt1 = new stdClass; $opt1->value = "106"; $opt1->name = "High Cube"; array_push($heightArr, $opt1);

$wallHeightOutArr = array ();
$opt1 = new stdClass; $opt1->value = "102_102"; $opt1->name = "8'6\""; array_push($wallHeightOutArr, $opt1);
$opt1 = new stdClass; $opt1->value = "114_114"; $opt1->name = "9'6\""; array_push($wallHeightOutArr, $opt1);

$invLengthArr = array ();
$opt1 = new stdClass; $opt1->value = "0_95"; 	$opt1->name = "below 8'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "96_180"; $opt1->name = "8' - 15'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "192_240"; $opt1->name = "16' - 20'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "252_372"; $opt1->name = "21' - 31'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "384_480"; $opt1->name = "32' - 40'"; array_push($invLengthArr, $opt1);
$opt1 = new stdClass; $opt1->value = "480_2000"; $opt1->name = "40' Plus"; array_push($invLengthArr, $opt1);


$specialFeatureArr = array ();
$opt1 = new stdClass; $opt1->value = "Doors"; $opt1->name = "Doors"; array_push($specialFeatureArr, $opt1);
$opt1 = new stdClass; $opt1->value = "Windows"; $opt1->name = "Windows"; array_push($specialFeatureArr, $opt1);
$opt1 = new stdClass; $opt1->value = "Roll_up_doors"; $opt1->name = "Roll up doors"; array_push($specialFeatureArr, $opt1);
$opt1 = new stdClass; $opt1->value = "Insulation"; $opt1->name = "Insulation"; array_push($specialFeatureArr, $opt1);
$opt1 = new stdClass; $opt1->value = "A/C"; $opt1->name = "A/C"; array_push($specialFeatureArr, $opt1);
$opt1 = new stdClass; $opt1->value = "Lighting"; $opt1->name = "Lighting"; array_push($specialFeatureArr, $opt1);

$groupTypeArr = array ();
$opt1 = new stdClass; $opt1->value = "trash trailers"; $opt1->name = "Trash Trailers"; array_push($groupTypeArr, $opt1);
$opt1 = new stdClass; $opt1->value = "oilfield trailers"; $opt1->name = "Oilfield Trailers"; array_push($groupTypeArr, $opt1);
$opt1 = new stdClass; $opt1->value = "equipment trailers"; $opt1->name = "Equipment Trailers"; array_push($groupTypeArr, $opt1);
?>
