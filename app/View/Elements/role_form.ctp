<?php echo $this->Form->create('Role', array('type'=>'file','class'=>'form-horizontal', 'action'=>($action == 'add' ? 'create' : 'update'))); ?>
   
    <div class="form-group">
        <label class="col-lg-3 control-label">Name</label>
        <div class="col-lg-5">
             <?php echo $this->Form->input('name', array('label'=>false,'class'=>"form-control" ,'data-bv-message'=>"The name is not valid",'required data-bv-notempty-message'=>"The name is required and cannot be empty",'pattern'=>"[a-zA-Z0-9_\.]+" ,'placeholder'=>'Name role')); ?>
                
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Level</label>
        <div class="col-lg-5">
             <?php echo $this->Form->input('level', array('label'=>false,'class'=>"form-control" ,'data-bv-message'=>"The level is not valid",'required data-bv-notempty-message'=>"The level is required and cannot be empty",'pattern'=>"[0-9_\.]+")); ?>
                
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Description</label>
        <div class="col-lg-5">
             <?php echo $this->Form->textarea('description', array( 'class'=>"form-control",'label'=>false, 'div'=>false)); ?>
              
        </div>
    </div>
<div class="form-group">
        <label class="col-lg-3 control-label">Actived</label>
        <div class="col-lg-5">
            <?php echo $this->Form->select('actived', $activeds, array('empty'=>false,'class'=>"form-control", 'tabindex'=>"2")); ?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="form-group">
	<div class="col-lg-9 col-lg-offset-3">
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'id'=>'btnCancel','class'=>'btn btn-danger')); ?>
            <?php echo $this->Form->submit('Save Client', array('div'=>false,'class'=>'btn btn-success')); ?>
        </div>
    </div>
<?php echo $this->Form->end(); ?>