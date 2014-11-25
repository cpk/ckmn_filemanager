<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'edit', $permission['Permission']['id'])); ?>">
            <i class="fa fa-edit"></i> Edit
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'delete', $permission['Permission']['id'])); ?>" onclick="return confirm('Are you sure ?')">
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
                    <td><?php echo $permission['Permission']['name'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Description:</span>
                    </td>
                    <td><?php echo $permission['Permission']['description'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Section:</span>
                    </td>
                    <td><?php echo $permission['Permission']['section'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Module:</span>
                    </td>
                    <td><?php echo $permission['Permission']['module'] ?></td>
                </tr>
                <tr class="">
                    <td>
                        <span>Status:</span>
                    </td>
                    <td>
                        <?php 
                            if($permission['Permission']['actived'])
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
                    <td class="center" colspan="2">
                        <a class="btn btn-info" href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'edit', $permission['Permission']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                        <a class="btn btn-danger delete" href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'delete', $permission['Permission']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
