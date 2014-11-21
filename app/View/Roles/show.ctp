
<script src="<?php echo $webroot; ?>/js/role.js"></script>
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
                        <td><?php echo $role['Role']['actived'] ?></td>
                    </tr>
                    <tr>
                        <td class="center" colspan="2">
                            <a class="btn btn-success btn-xs viewPermission" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i>View Permissions</a> 
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