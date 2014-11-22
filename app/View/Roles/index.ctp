
<script src="<?php echo $webroot; ?>/js/role.js"></script>
<div class="the-box">
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="datatable-example">
            <thead class="the-box dark full">
                <tr>
                    <th class="center" width="30px">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="display: none;">Permissions</th>
                    <th class="center" width="220px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($roles); $i++) { ?>
                    <tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even' ?>gradeX">
                        <td>
                            <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'show', $roles[$i]['Role']['id'])); ?>">
                                RO<?php echo $roles[$i]['Role']['id'] ?>
                            </a>
                        </td>
                        <td><?php echo $roles[$i]['Role']['name'] ?></td>
                        <td><?php echo $roles[$i]['Role']['description'] ?></td>
                        <td class="role_permissions" style="display: none;">
                            <table class="table table-striped table-hover">
                                <thead class="the-box dark full">
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($j = 0; $j < count($roles[$i]['Role']['Permission']); $j++) { ?>
                                        <tr class="<?php echo ($j % 2 == 0) ? 'odd' : 'even' ?>gradeX">
                                            <td>
                                                <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'show', $roles[$i]['Role']['Permission'][$j]['Permission']['id'])); ?>">
                                                    PM<?php echo $roles[$i]['Role']['Permission'][$j]['Permission']['id'] ?>
                                                </a>
                                            </td>
                                            <td><?php echo $roles[$i]['Role']['Permission'][$j]['Permission']['name'] ?></td>
                                            <td><?php echo $roles[$i]['Role']['Permission'][$j]['Permission']['description'] ?></td>
                                        </tr>
                                    <?php } ?>  
                                </tbody>
                            </table>
                        </td>
                        <td class="center">
                            <a class="btn btn-success btn-xs viewPermission" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i>View Permissions</a> 
                            <a class="btn btn-info btn-xs" href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'edit', $roles[$i]['Role']['id'])); ?>"><i class="fa fa-edit"></i>Edit</a>
                            <a class="btn btn-danger btn-xs delete" href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'delete', $roles[$i]['Role']['id'])); ?>" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash-o"></i>Delete</a>
                        </td>
                    </tr>
                <?php } ?>                
            </tbody>
        </table>
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
</div>