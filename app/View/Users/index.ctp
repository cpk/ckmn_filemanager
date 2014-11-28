<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'create')); ?>">
            <i class="fa fa-plus"></i> Create
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'export')); ?>">
            <i class="fa fa-share-square-o"></i> Export
        </a>
    </div>
    <div class="float-left">
        <a href="#" onclick="return printElem('.table', 'List Users');">
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="center" width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($users); $i++) { ?>
                    <tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even' ?>gradeX">
                        <td>
                            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'show', $users[$i]['User']['id'])); ?>">
                                US<?php echo $users[$i]['User']['id'] ?>
                            </a>
                        </td>
                        <td><?php echo $users[$i]['User']['first_name'] . ' ' . $users[$i]['User']['last_name'] ?></td>
                        <td><?php echo $users[$i]['User']['username'] ?></td>
                        <td><?php echo $users[$i]['User']['email'] ?></td>
                        <td>
                            <?php for ($j = 0; $j < count($users[$i]['User']['Role']); $j++) { ?>
                                <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'show', $users[$i]['User']['Role'][$j]['Role']['id'])); ?>">
                                    <?php echo $users[$i]['User']['Role'][$j]['Role']['description'] ?>
                                </a><br/>
                            <?php } ?> 
                        </td>
                        <td> 
                            <?php 
                                if($users[$i]['User']['actived'])
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
                        <td class="center">
                            <a class="btn btn-info btn-xs" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit', $users[$i]['User']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                            <a class="btn btn-danger btn-xs delete" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete', $users[$i]['User']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                        </td>
                    </tr>
                <?php } ?>                
            </tbody>
        </table>
    </div>
</div>