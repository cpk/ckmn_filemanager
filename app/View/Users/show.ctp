<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); ?>">
            <i class="fa fa-edit"></i> Edit
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete', $user['User']['id'])); ?>" onclick="return confirm('Are you sure ?')">
            <i class="fa fa-trash-o"></i> Delete
        </a>
    </div>
</div>
<div class="clear"></div>
<div class="the-box">
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="datatable-example">

            <tbody>
                <tr class="">
                    <td>
                        <span>Name:</span>
                    </td>
                    <td><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Username:</span>
                    </td>
                    <td><?php echo $user['User']['username'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Email:</span>
                    </td>
                    <td><?php echo $user['User']['email'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Status:</span>
                    </td>
                    <td><?php echo $user['User']['actived'] ?></td>
                </tr>
                <tr class="">
                    <td colspan="2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Role:</h3>
                            </div>
                            <div class="panel-body">
                                <?php for ($i = 0; $i < count($roles); $i++) { ?>
                                    <div class="float-left" style="width: 22%;">
                                        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'show', $roles[$i]['Role']['id'])); ?>">
                                            <?php echo $roles[$i]['Role']['name']; ?>
                                        </a>                                       
                                    </div>
                                <?php } ?> 
                            </div><!-- /.panel-body -->                                
                        </div><!-- /.panel panel-primary -->
                        <div class="clear"></div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Permission:</h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                for ($i = 0; $i < count($permissions); $i++) {
                                    $name = explode('.', $permissions[$i]['name']);
                                    $controller = $name[0];
                                ?>
                                <div class="boxPermission">
                                    <div class="titlePermission">
                                        <?php echo $controller; ?>
                                    </div>
                                    <div class="clear"></div>
                                <?php
                                    for ($j = $i; $j < count($permissions); $j++) {
                                        $name = explode('.', $permissions[$j]['name']);
                                        if(($controller != $name[0] || $j == count($permissions) - 1)){ 
                                            if($j == count($permissions) - 1){
                                                $i = $j;
                                ?>
                                        <div class="float-left" style="width: 22%;">
                                            <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'show', $permissions[$j]['id'])); ?>">
                                                <?php echo $name[1]; ?>
                                            </a>                                       
                                        </div>
                                <?php          
                                            }else{
                                                $i = $j - 1;
                                            }                                            
                                            $j = count($permissions);
                                        }else{
                                ?>
                                        <div class="float-left" style="width: 22%;">
                                            <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'show', $permissions[$j]['id'])); ?>">
                                                <?php echo $name[1]; ?>
                                            </a>                                       
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
                    </td>
                </tr>
                <tr>
                    <td class="center" colspan="2">
                        <a class="btn btn-info" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                        <a class="btn btn-danger delete" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete', $user['User']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
