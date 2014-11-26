<div class="row">
	<div class="col-xs-12 col-sm-9">
		<div class="well" style="background-color: #fff;">
			<ul class="list-inline">
				<li>
					<i class="fa fa-star text-warning"></i>
					<i class="fa fa-star text-warning"></i>
					<i class="fa fa-star text-warning"></i>
					<i class="fa fa-star text-warning"></i>
					<i class="fa fa-star"></i>
				</li>
				<li>
					<span>26/11/2014 10:20 AM</span>
				</li>
				<li class="pull-right">
					<img src="/img/avatar/avatar-1.jpg" class="avatar img-circle" alt="Avatar">
					<strong>Tổng giám đốc</strong>
				</li>
			</ul>
		</div>
		<div class="well" style="background-color: #fff;">
			<img src="/img/thongbao2.jpg" class="img-responsive" alt=""/>
			<hr/>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				Debitis enim esse harum inventore nam quae quasi tempore velit?
				Accusantium ad nam quo voluptatibus. Beatae, maxime, voluptatum! Nulla tempore vero voluptates?
			</p>
			<div>
				<ul class="list-inline">
					<li><strong>Tags:</strong></li>
					<?php
					$tags = array('lương', 'nghỉ lễ', 'nhân sự', 'tổng kết', 'báo cáo', 'khen thưởng');
					shuffle($tags);
					$tags = array_slice($tags, 0, rand(2,6));
					$colors = array('primary', 'info', 'success', 'danger', 'warning');
					foreach($tags as $tag){
						$color = $colors[array_rand($colors)];
						echo '<li><span class="label label-'.$color.'">'.$tag.'</span></li>';
					}
					?>
				</ul>
			</div>
			<div style="border-top: 1px dashed #ddd;">
				<p>
					<strong>
						Đính kèm:
					</strong>
				</p>
				<ul class="attachment-list">
					<li><a href="#fakelink">Cerita hantu part 2.docx</a> - <small>1,245 Kb</small></li>
					<li><a href="#fakelink">List belanja bulan April.xlsx</a> - <small>32 Kb</small></li>
					<li><a href="#fakelink">Tutorial membuat webset.pdf</a> - <small>35,245 Kb</small></li>
					<li><a href="#fakelink">Cerita hantu part 3.docx</a> - <small>1,545 Kb</small></li>
					<li><a href="#fakelink">Photo kenangan.zip</a> - <small>20,545 Kb</small></li>
				</ul>
				<button class="btn btn-info"><i class="fa fa-cloud-download"></i> Tải về tất cả</button>
			</div>

			<div style="margin-top:20px; border-top: 1px dashed #ddd;">
				<p>
					<strong>Các thông báo khác</strong>
				</p>
				<ul class="list-unstyled">
					<?php
					foreach(range(1,4) as $item){
						?>
						<li style="margin-bottom: 10px;">
							<div class="media-body">
								<h4 class="media-heading">
									<a href="#">Lorem ipsum dolor sit amet</a>
								</h4>
								<p class="text-danger"><small>April 20, 2014</small></p>
								<p>Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
							</div>
						</li>
					<?php
					}
					?>
				</ul>
			</div>

		</div>
	</div>
	<div class="col-xs-12 col-sm-3">
		<div class="list-group">
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item active list-group-item-info">Thông báo Công ty</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Thông báo hành chính</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Khen thưởng</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Porta ac consectetur ac</a>
			<a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index'));?>" class="list-group-item">Vestibulum at eros</a>
		</div>
	</div>
</div>