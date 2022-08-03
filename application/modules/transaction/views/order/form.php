<?php

if (empty($data)) {
    $data = array(
      "id" => 0,
      "name" => "",
      "address" => "",
      "phone" => "",
      "email" => "",
      "contact_person" => "",
      "mapurl" => "",
      "isbranch" => 0,
    );
}else{
    $data = (array)$data;
}
?>
<input type="hidden" value="<?= $data["id"]; ?>" class="form-control" name="txtCompanyId"
       id="txtCompanyId"
       placeholder="Branch Name">

<div class="col-sm-6">
    <div class="form-group row">
        <label for="txtName" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["name"]; ?>" class="form-control" name="txtName"
                   id="txtName"
                   placeholder="Branch Name">
        </div>
    </div>
    <div class="form-group row">
        <label for="txtAddress" class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["address"]; ?>" class="form-control" name="txtAddress"
                   id="txtAddress"
                   placeholder="Nama Cabang">
        </div>
    </div>
    <div class="form-group row">
        <label for="txtPhone" class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["phone"]; ?>" class="form-control" name="txtPhone"
                   id="txtPhone"
                   placeholder="Phone">
        </div>
    </div>
    <div class="form-group row">
        <label for="Email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" value="<?= $data["email"]; ?>" class="form-control email" name="txtEmail"
                   id="txtEmail"
                   placeholder="Email">
        </div>
    </div>
    <div class="form-group row">
        <label for="txtContactPerson" class="col-sm-3 col-form-label">Contact Person</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["contact_person"]; ?>" class="form-control" name="txtContactPerson"
                   id="txtContactPerson"
                   placeholder="Contact Person">
        </div>
    </div>
    <div class="form-group row">
        <label for="cboIsBranch" class="col-sm-3 col-form-label">Is Branch</label>
        <div class="col-sm-9">
            <input type="checkbox" <?= $data["isbranch"] == "1" ? "checked":""; ?> class="checkbox" 
                   name="cboIsBranch"
                   id="cboIsBranch">
        </div>
    </div>
    <div class="form-group row">
        <label for="txtGoogleMap" class="col-sm-3 col-form-label">Google Map URL</label>
        <div class="col-sm-9">
            <input type="text" value="<?= $data["mapurl"]; ?>" class="form-control" name="txtGoogleMap"
                   id="txtGoogleMap"
                   placeholder="Google Map URL">
        </div>
    </div>
</div>
<div class="col-sm-6">
    <?= html_entity_decode($data["mapurl"]); ?>
</div>