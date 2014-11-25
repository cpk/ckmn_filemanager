<?php echo $this->Form->create('User', array('type' => 'file', 'class' => 'form-horizontal', 'action' => ($action == 'create' ? 'create' : 'edit'))); ?>

<div class="form-group">
    <label class="col-lg-3 control-label">Name</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('first_name', array('label' => false, 'value' => isset($user['User']['first_name']) ? $user['User']['first_name'] : '', 'class' => "form-control", 'data-bv-message' => "The firt name is not valid", 'required data-bv-notempty-message' => "The name is required and cannot be empty", 'pattern' => "[a-zA-Z0-9_\.]+", 'placeholder' => 'First Name')); ?>
        <?php echo $this->Form->input('last_name', array('label' => false, 'value' => isset($user['User']['last_name']) ? $user['User']['last_name'] : '', 'class' => "form-control", 'data-bv-message' => "The last name is not valid", 'required data-bv-notempty-message' => "The name is required and cannot be empty", 'pattern' => "[a-zA-Z0-9_\.]+", 'placeholder' => 'Last Name')); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Username</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username','readonly' => ($action == 'create' ?  '': 'readonly'), 'value' => isset($user['User']['username']) ? $user['User']['username'] : '', 'class' => "form-control",  'required data-bv-notempty-message' => "The level is required and cannot be empty", 'pattern' => "[0-9_\.]+")); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Email</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('email', array('class' => "form-control", 'readonly' => ($action == 'create' ?  '': 'readonly'), 'value' => isset($user['User']['email']) ? $user['User']['email'] : '', 'label' => false, 'div' => false,'placeholder' => 'Email')); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Password</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('password', array('class' => "form-control", 'label' => false, 'div' => false,'placeholder' => 'Password')); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Confirm Password</label>
    <div class="col-lg-5">
        <?php echo $this->Form->input('retype_password', array('class' => "form-control", 'type'=>"password" , 'label' => false, 'div' => false,'placeholder' => 'Confirm Password')); ?>

    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Status</label>
    <div class="col-lg-5">
        <?php echo $this->Form->select('actived', $activeds, array('empty' => false, 'value' => isset($user['User']['actived']) ? $user['User']['actived'] : '', 'class' => "form-control", 'tabindex' => "2")); ?>
    </div>
</div>
 <div class="clear"></div>
<div class="form-group">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Role:</h3>
        </div>
        <div class="panel-body">
            <?php  for ($i = 0; $i < count($roles); $i++) { ?>
                <div class="float-left" style="width: 22%;">
                    <?php echo $this->Form->input($roles[$i]['Role']['name'], array('type' => 'checkbox', 'value' => isset($roles[$i]['Role']['id']) ? $roles[$i]['Role']['id'] : "", isset($roles[$i]['Role']['allow']) && $roles[$i]['Role']['allow'] == 1 ? 'checked' : '')); ?>                                      
                </div>
            <?php } ?> 
        </div><!-- /.panel-body -->                                
    </div><!-- /.panel panel-primary -->
    <div class="clear"></div>
</div>
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
        <?php echo $this->Form->button('Cancel', array('type' => 'button', 'id' => 'btnCancel', 'class' => 'btn btn-danger')); ?>
        <?php echo $this->Form->submit('Save User', array('div' => false, 'class' => 'btn btn-success')); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>