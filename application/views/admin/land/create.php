<?php
$this->load->view('templates/_admin_parts/create');
?>

<script>
	const area = document.getElementsByName('land_area')[0];
	const price = document.getElementsByName('price')[0];
	const total = document.getElementsByName('total_price')[0];

	console.log(total);

	var area_val = 0;
	var price_val = 0;
	var total_val = 0;

	area.onchange = function() {
		area_val = area.value;
		price_val = price.value;
		total.value = area_val * price_val;
	}

	price.onchange = function() {
		area_val = area.value;
		price_val = price.value;
		total.value = area_val * price_val;
	}
</script>