
<script src="<?php echo $webroot; ?>js/role.js"></script>
<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'edit', $role['Role']['id'])); ?>">
            <i class="fa fa-edit"></i> Edit
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete', $role['Role']['id'])); ?>" onclick="return confirm('Are you sure ?')">
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
                        <td><?php echo $role['Role']['name'] ?></td>
                    </tr>
                     <tr class="">
                        <td>
                            <span>Level:</span>
                        </td>
                        <td><?php echo $role['Role']['level'] ?></td>
                    </tr>
                    <tr class="">
                        <td>
                            <span>Description:</span>
                        </td>
                        <td><?php echo $role['Role']['description'] ?></td>
                    </tr>
                     <tr class="">
                        <td>
                            <span>Actived:</span>
                        </td>
                        <td>
                            <?php
                            if($role['Role']['actived'])
                                {
                                    ?>
                                        <span class="label label-info">Active</span>
                                    <?php
                                }
                                else 
                                {
                                    ?>
                                        <span class="label label-danger">Inactive</span>
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
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
                            <a class="btn btn-info btn-xs" href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'edit', $role['Role']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                            <a class="btn btn-danger btn-xs delete" href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'delete', $role['Role']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
     <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"
                                                                                   data-toggle="tooltip"
                                                                                   title="Permissions">&times;</span><span
                            class="sr-only"><g:message code="close.label"/></span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        List Permissions
                    </h4>
                </div>

                <div class="modal-body">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>