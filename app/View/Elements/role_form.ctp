<?php echo $this->Form->create('Role', array('type'=>'file','class'=>'form-horizontal', 'action'=>($action == 'create' ? 'create' : 'edit'))); ?>
   
    <div class="form-group">
        <label class="col-lg-3 control-label">Name</label>
        <div class="col-lg-5">
             <?php echo $this->Form->input('name', array('label'=>false,'class'=>"form-control", 'value' => isset($role['Role']['name']) ? $role['Role']['name'] : '','data-bv-message'=>"The name is not valid",'required data-bv-notempty-message'=>"The name is required and cannot be empty",'pattern'=>"[a-zA-Z0-9_\.]+" ,'placeholder'=>'Name role')); ?>
                
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Level</label>
        <div class="col-lg-5">
             <?php echo $this->Form->input('level', array('label'=>false,'class'=>"form-control" , 'value' => isset($role['Role']['level']) ? $role['Role']['level'] : '','data-bv-message'=>"The level is not valid",'required data-bv-notempty-message'=>"The level is required and cannot be empty",'pattern'=>"[0-9_\.]+")); ?>
                
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Description</label>
        <div class="col-lg-5">
             <?php echo $this->Form->textarea('description', array( 'class'=>"form-control", 'value' => isset($role['Role']['description']) ? $role['Role']['description'] : '','label'=>false, 'div'=>false)); ?>
              
        </div>
    </div>
<div class="form-group">
        <label class="col-lg-3 control-label">Actived</label>
        <div class="col-lg-5">
            <?php echo $this->Form->select('actived', $activeds, array('empty'=>false,'class'=>"form-control", 'value' => isset($role['Role']['actived']) ? $role['Role']['actived'] : '','tabindex'=>"2")); ?>
        </div>
    </div>
<div class="clear"></div>
<div class="form-group">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Permission:</h3>
        </div>
        <div class="panel-body">
            <?php
            for ($i = 0; $i < count($permissions); $i++) {
                $name = explode('.', $permissions[$i]['Permission']['name']);
                $controller = $name[0];
                ?>
                <div class="boxPermission">
                    <div class="titlePermission">
                        <?php echo $controller; ?>
                    </div>
                    <div class="clear"></div>
                    <?php
                    for ($j = $i; $j < count($permissions); $j++) {
                        $name = explode('.', $permissions[$j]['Permission']['name']);
                        if (($controller != $name[0] || $j == count($permissions) - 1)) {
                            if ($j == count($permissions) - 1) {
                                $i = $j;
                                ?>
                                <div class="float-left" style="width: 22%;">
                                    <?php echo $this->Form->input($permissions[$j]['Permission']['name'], array('type' => 'checkbox', 'value' => isset($permissions[$j]['Permission']['id']) ? $permissions[$j]['Permission']['id'] : "", isset($permissions[$j]['Permission']['allow']) && $permissions[$j]['Permission']['allow'] == 1 ? 'checked' : '')); ?>                                                                            
                                </div>
                                <?php
                            } else {
                                $i = $j - 1;
                            }
                            $j = count($permissions);
                        } else {
                            ?>
                            <div class="float-left" style="width: 22%;">
                                <?php echo $this->Form->input($permissions[$j]['Permission']['name'], array('type' => 'checkbox', 'value' => isset($permissions[$j]['Permission']['id']) ? $permissions[$j]['Permission']['id'] : "", isset($permissions[$j]['Permission']['allow']) && $permissions[$j]['Permission']['allow'] == 1 ? 'checked' : '')); ?>                                                                                                                  
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clear"></div>
                </div>   
                <div class="clear"></div>
                <?php
            }
            ?> 
        </div><!-- /.panel-body -->                                
    </div><!-- /.panel panel-primary -->
    <div class="clear"></div>
</div>

    <div class="clear"></div>
    <div class="form-group">
	<div class="col-lg-9 col-lg-offset-3">
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'id'=>'btnCancel','class'=>'btn btn-danger')); ?>
            <?php echo $this->Form->submit('Save Client', array('div'=>false,'class'=>'btn btn-success')); ?>
        </div>
    </div>
<?php echo $this->Form->end(); ?>