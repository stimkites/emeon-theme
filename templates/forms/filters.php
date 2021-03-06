<?php
/**
 * Template for recover password
 */

defined( 'ABSPATH' ) or exit;

$email = $_GET[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<div class="form-check form-switch filters-toggling mb-5">
	<form action="?"
	      method="GET"
	      class="emeon-form form-filters w-100 rounded-3 border-0 p-4"
	      id="emeon-form-filters"
	      enctype="application/x-www-form-urlencoded"
	      name="emeon-form-filters">

		<div class="switch-wrapper mb-2 d-flex align-items-center justify-content-start">
			<input id="toggle_filters"
			       class="form-check-input border-secondary bg-secondary btn-secondary text-secondary"
			       type="checkbox" name="toggle_filters" value="yes"/>
			<label for="toggle_filters" class="form-check-label d-block ms-2">Filters</label>
		</div>

		<fieldset class="fieldset">
			<p>
				<label class="fs-6 text-black-50" for="filters-select">Categories</label>
				<select class="sel2 select select-categories form-select border-0"
				        id="filters-select"
				        data-placeholder="Choose categories to filter"
				        multiple
				        name="f[cats][]">
					<?= apply_filters( 'emeon_cats', '', $_GET[ 'f' ][ 'cats' ] ?? [] ) ?>
				</select>
			</p>
			<p>
				<label class="fs-6 text-black-50" for="experience-select">Experience (from)</label>
				<select class="sel2 select select-experience form-select border-0"
				        id="experience-select"
				        data-placeholder="Choose experience level"
				        name="f[exp]">
					<?php
					foreach ( EMEON_EXP_LVL as $index => $lvl ) {
						echo '<option ' .
						     ( $index == ( $_GET[ 'f' ][ 'exp' ] ?? 0 )
							     ? 'selected'
							     : ''
						     ) . '
                                value="' . $index . '">' . $lvl .
						     '</option>';
					}
					?>
				</select>
			</p>
			<p>
				<label class="fs-6 text-black-50" for="salary-select">Salary (from)</label>
				<input type="number"
				       id="salary-select"
				       class="invalidate form-control border-0 emeon-salary"
				       name="f[sal]"
				       pattern="[0-9]" step="50" min="0"
				       value="<?= $_GET[ 'f' ][ 'sal' ] ?? '' ?>"
				       placeholder="Salary from (EUR)"/>
				<span class="input-group-text border-0 rounded-0 cur-symbol"><?= EMEON_CUR_SYMB ?></span>
			</p>
			<p class="filters-cta">
				<label for="toggle_filters" class="filters-cancel btn btn-outline-secondary">Cancel</label>
				<button class="btn btn-primary" type="submit">Apply</button>
			</p>

			<input type="hidden" name="s" value="<?= $_GET[ 's' ] ?? '' ?>"/>

		</fieldset>
	</form>
</div>
