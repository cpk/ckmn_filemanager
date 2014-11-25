<?php echo $this->Form->create('Permission', array('type' => 'file', 'class' => 'form-horizontal', 'action' => ($action == 'create' ? 'create' : 'edit'))); ?>

<div class="form-group">
    <label class="col-lg-3 control-label">Name</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('name', array('label' => false, 'value' => isset($permission['Permission']['name']) ? $permission['Permission']['name'] : '', 'class' => "form-control", 'data-bv-message' => "The name is not valid", 'required data-bv-notempty-message' => "The name is required and cannot be empty", 'pattern' => "[a-zA-Z0-9_\.]+", 'placeholder' => 'Permission Name')); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Description</label>
    <div class="col-lg-5">
        <?php echo $this->Form->textarea('description', array( 'class'=>"form-control", 'value' => isset($permission['Permission']['description']) ? $permission['Permission']['description'] : '','label'=>false, 'div'=>false)); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Section</label>
    <div class="col-lg-5">
        <?php echo $this->Form->textarea('section', array( 'class'=>"form-control", 'value' => isset($permission['Permission']['section']) ? $permission['Permission']['section'] : '','label'=>false, 'div'=>false)); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Module</label>
    <div class="col-lg-5">
        <?php echo $this->Form->textarea('module', array( 'class'=>"form-control", 'value' => isset($permission['Permission']['module']) ? $permission['Permission']['module'] : '','label'=>false, 'div'=>false)); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Status</label>
    <div class="col-lg-5">
        <?php echo $this->Form->select('actived', $activeds, array('empty' => false, 'value' => isset($permission['Permission']['actived']) ? $permission['Permission']['actived'] : '', 'class' => "form-control", 'tabindex' => "2")); ?>
    </div>
</div>
<div class="clear"></div>
<div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
        <?php echo $this->Form->button('Cancel', array('type' => 'button', 'id' => 'btnCancel', 'class' => 'btn btn-danger')); ?>
        <?php echo $this->Form->submit('Save Permission', array('div' => false, 'class' => 'btn btn-success')); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>