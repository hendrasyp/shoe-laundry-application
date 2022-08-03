<?php

if (empty($data)) {
    $data = array(
      "id" => 0,
      "typename" => "",
      "typeprice" => "",
      "isextra" => "No",
      "typedescription" => "",
      "point" => 0,
      "estimate_day" => 0,
    );
}else{
    $data = (array)$data;
}
?>
<input type="hidden" value="<?= $data["id"]; ?>" class="form-control" name="txtServiceId"
       id="txtServiceId">
<div class="col-md-6">
    <div class="form-group row">
        <label for="txtName" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["typename"]; ?>" class="form-control" name="txtName"
                   id="txtName"
                   placeholder="Service Name">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="cboIsExtra" class="col-sm-3 col-form-label">Is Extra Service</label>
        <div class="col-sm-9">
            <input type="checkbox" <?= $data["isextra"] == "Yes" ? "checked":""; ?> class="checkbox" 
                   name="cboIsExtra"
                   id="cboIsExtra">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="txtPrice" class="col-sm-3 col-form-label">Base Price</label>
        <div class="col-sm-9">
            <input type="number" value="<?= $data["typeprice"]; ?>" class="form-control" name="txtPrice"
                   id="txtPrice"
                   placeholder="Price">
        </div>
    </div>
    
     <div class="form-group row">
        <label for="txtDescription" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["typedescription"]; ?>" class="form-control" name="txtDescription"
                   id="txtDescription"
                   placeholder="Description">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="txtPoint" class="col-sm-3 col-form-label">Point</label>
        <div class="col-sm-9">
            <input type="number" value="<?= $data["point"]; ?>" class="form-control" name="txtPoint"
                   id="txtPoint"
                   placeholder="Point">
        </div>
    </div>

	<div class="form-group row">
		<label for="txtEstimate" class="col-sm-3 col-form-label">Estimate finish day</label>
		<div class="col-sm-9">
			<input type="number" value="<?= $data["estimate_day"]; ?>" class="form-control" name="txtEstimate"
				   id="txtEstimate"
				   placeholder="Day Estimate">
		</div>
	</div>
</div>
