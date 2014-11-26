<div class="row">
	<div class="col-xs-12 col-sm-9">
		<div class="well" style="background-color: #fff;">
			<ul class="media-list">
				<?php

				foreach ( range( 1, 10 ) as $new ) {
					?>
					<li class="media">
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'read'));?>">
									<?php
									if($new < 4){
										echo '<strong>Báo cáo Lorem dolor sit amet, consectetuer adipiscing elit</strong> <span class="badge badge-danger">New</span>';
									}else{
										echo 'Báo cáo Lorem dolor sit amet, consectetuer adipiscing elit';
									}
									?>
								</a>
							</h4>

							<p>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star"></i> |
								<span>26/11/2014 10:20 AM</span>
							</p>

							<p class="text-muted">
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
							</p>
							<ul class="list-inline">
								<?php
								$tags = array('Việc A', 'Việc B', 'Việc C', 'Quý 1', 'Tháng 2', 'Tuần 3', 'Năm' );
								shuffle($tags);
								$tags = array_slice($tags, 0, rand(2,4));
								$colors = array('primary', 'info', 'success', 'danger', 'warning');
								foreach($tags as $tag){
									$color = $colors[array_rand($colors)];
									echo '<li><span class="label label-'.$color.'">'.$tag.'</span></li>';
								}
								?>
							</ul>
						</div>
						<hr/>
					</li>
				<?php
				}
				?>
			</ul>
			<div class="text-center">
				<ul class="pagination">
					<li><a href="#">&laquo;</a></li>
					<li class="active bg-info"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">&raquo;</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-3">
		<div class="list-group">
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item active list-group-item-info">Báo cáo Công ty</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Báo cáo hành chính</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Báo cáoKhen thưởng</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Porta ac consectetur ac</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Vestibulum at eros</a>
		</div>
	</div>
</div>