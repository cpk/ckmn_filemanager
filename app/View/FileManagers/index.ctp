<?php
echo $this->Html->css( 'jsTree/default/style.min' );
?>
<div class="row">
	<div class="col-xs-12 col-sm-2">
		<div id="jstree_demo_div">
			<ul>
				<li>Root node 1</li>
				<li>Root node 2</li>
			</ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-10">
		<div class="well" style="background-color:#fff;">
			<div class="btn-toolbar">
				<div class="btn-group">
					<button type="button" class="btn btn-success">
						<i class="fa fa-upload"></i> Upload
					</button>
					<button type="button" class="btn btn-success" title="Create folder">
						<i class="fa fa-plus"></i>
					</button>

				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-primary">Left</button>
					<button type="button" class="btn btn-primary">Middle</button>
					<button type="button" class="btn btn-primary">Right</button>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-primary">Left</button>
					<button type="button" class="btn btn-primary">Middle</button>
					<button type="button" class="btn btn-primary">Right</button>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-info">Action</button>
					<button type="button" class="btn btn-info active dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu info" role="menu">
						<li><a href="#fakelink">Tên</a></li>
						<li><a href="#fakelink">Kích thước</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /.the-box no-border -->


		<div class="row">
			<?php
			foreach ( $items as $item ) {
				echo $this->element( 'FileManagerItem', $item );
			}
			?>
		</div>
		<!-- /.row -->


	</div>
</div>

<?php
echo $this->Html->script( 'jsTree/jstree.min' );
?>
<script>

	$(document).ready(function () {
		$('#jstree_demo_div').jstree();
		$('#jstree_demo_div').on("changed.jstree", function (e, data) {
			console.log(data.selected);
		});
	});
</script>