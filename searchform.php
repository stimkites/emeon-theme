<?php
/**
 * Created by PhpStorm.
 * User: stim
 * Date: 10/20/21
 * Time: 10:00 AM
 */

$_id = rand();
?>
<form action="/" id="search-form-<?= $_id ?>" method="GET" enctype="application/x-www-form-urlencoded" class="search-filters">
	<fieldset class="search-field">
		<select class="search emeon-search-select"
		        id="search-select-<?= $_id ?>"
		        data-placeholder="Search..."
		        name="s">
			<?=apply_filters( 'emeon_search', '', $_GET['s']??'' )?>
		</select>
	</fieldset>
	<span id="search-close"></span>
</form>

