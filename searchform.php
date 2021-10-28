<?php
/**
 * Created by PhpStorm.
 * User: stim
 * Date: 10/20/21
 * Time: 10:00 AM
 */

$_id = rand();
?>
<form action="/" id="search-form-<?= $_id ?>" method="post" enctype="multipart/form-data" class="search-filters">
	<fieldset class="search-field">
		<select class="search emeon-search-select"
		        id="search-select-<?= $_id ?>"
		        data-placeholder="Search..."
		        name="s">
			<?=apply_filters( 'emeon_search', '', $_POST['s']??'' )?>
		</select>
	</fieldset>
	<span id="search-close"></span>
</form>

