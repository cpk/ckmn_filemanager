<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'create')); ?>">
            <i class="fa fa-plus"></i> Create
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'export')); ?>">
            <i class="fa fa-share-square-o"></i> Export
        </a>
    </div>
    <div class="float-left">
        <a href="#" onclick="return printElem('.table', 'List Permissions');">
            <i class="fa fa-print"></i> Print
        </a>
    </div>
</div>
<div class="clear"></div>
<div class="the-box">
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="datatable-example">
            <thead class="the-box dark full">
                <tr>
                    <th class="center" width="30px">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Section</th>
                    <th>Module</th>
                    <th>Status</th>
                    <th class="center" width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($permissions); $i++) { ?>
                    <tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even' ?>gradeX">
                        <td>
                            <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'show', $permissions[$i]['Permission']['id'])); ?>">
                                PE<?php echo $permissions[$i]['Permission']['id'] ?>
                            </a>
                        </td>
                        <td><?php echo $permissions[$i]['Permission']['name']?></td>
                        <td><?php echo $permissions[$i]['Permission']['description'] ?></td>
                        <td><?php echo $permissions[$i]['Permission']['section'] ?></td>
                        <td><?php echo $permissions[$i]['Permission']['module'] ?></td>
                        <td>
                            <?php 
                                if($permissions[$i]['Permission']['actived'])
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
                        <td class="center">
                            <a class="btn btn-info btn-xs" href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'edit', $permissions[$i]['Permission']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                            <a class="btn btn-danger btn-xs delete" href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'delete', $permissions[$i]['Permission']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                        </td>
                    </tr>
                <?php } ?>                
            </tbody>
        </table>
    </div>
</div>