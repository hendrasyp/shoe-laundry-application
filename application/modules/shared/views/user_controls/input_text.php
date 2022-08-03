<?php

$placeholder = "";
$value = "";
$readonly = '';

if (array_key_exists('placeholder', $param)) {
	$placeholder = $param['placeholder'];
}else{
	$placeholder = $param['label'];

}

if (array_key_exists('value', $param)) {
	$value = $param['value'];
}

if (array_key_exists('readonly', $param)) {
	if ($param['readonly'] == true) {
		$readonly = 'readonly="readonly"';
	}
}

?>

<div class="form-group row">
	<label for="<?= $param['id'] ?>"
		   class="col-sm-3 col-form-label"><?= $param['label'] ?>
	</label>
	<div class="col-sm-9">
		<input <?= $readonly; ?>
				type="text"
				value="<?= $value ?>"
				class="form-control"
				name="<?= $param['id'] ?>"
				id="<?= $param['id'] ?>"
				placeholder="<?= $placeholder ?>">
	</div>
</div>
