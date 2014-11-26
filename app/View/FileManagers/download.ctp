<?php
	if(!empty($infos)){
		foreach($infos as $info){
			?>
			<div class="alert alert-info">
				<?php echo $info['content']; ?>
			</div>
			<?php
		}
	}else{
		?>
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-download"></i> Tải tập tin</div>
			<div class="panel-body">
				<div class="media">
			<span class="pull-left">
				<?php
				echo $this->Html->image('filemanager/files/archive-v3.png', array(
					'class'=>'media-object'
				));
				?>
			</span>

					<div class="media-body">
						<h4 class="media-heading"><?php echo $file['file_name']; ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid blanditiis cupiditate debitis, dolor eligendi enim harum mollitia neque non placeat praesentium quam quo sapiente sint veniam vitae. Facere, velit?</p>
						<button type="button" class="btn btn-info btn-lg pull-right">
							<i class="fa fa-download"></i> Download
						</button>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
