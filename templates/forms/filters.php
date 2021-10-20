<?php
/**
 * Template for recover password
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? $_GET[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" "
      method="post"
      class="emeon-form form-filters"
      id="emeon-form-filters"
      enctype="multipart/form-data"
      name="emeon-form-filters" >
	<h3>Filters</h3>
	<fieldset>
		<p>
			<label>
				Filter by categories
				<select class="sel2 select select-categories form-select border-0"
				        id="filters-select"
				        data-placeholder="Categories..."
				        multiple
				        name="f[cats][]">
					<?=apply_filters( 'emeon_cats', '', $_POST['f']['cats']??[] )?>
				</select>
			</label>
		</p>
		<p>
			<label>
				Experience level
				<select class="sel2 select select-experience form-select"
				        id="experience-select"
				        multiple
				        name="f[exp][]">
					<?php
					foreach ( EMEON_EXP_LVL as $index => $lvl )
						echo '<option ' .
						     ( in_array( $index, $_POST['f']['exp'] ?? [] )
							     ? 'selected'
							     : ''
						     ) . '
                                value="' . $index . '">' . $lvl .
						     '</option>';
					?>
				</select>
			</label>
		</p>
		<p>
			<label>
				Salary level
				<input type="number" class="invalidate form-control border-0 emeon-salary"
				       name="f[sal]"
				       pattern="[0-9]" step="50" min="0"
				       value="<?= $_POST['f']['sal'] ?? '' ?>"
				       placeholder="Salary from (EUR)"/>
				<span class="input-group-text border-0 rounded-0 cur-symbol"><?= EMEON_CUR_SYMB ?></span>
			</label>
		</p>
		<p class="filters-cta">
			<button class="btn btn-primary" type="submit">Apply</button>
			<button class="btn btn-secondary" type="reset">Reset</button>
		</p>
	</fieldset>
</form>
