
<h1>sale order</h1>
<div class="row">
	<div class="col-xs-12">
		<h3 class="header smaller lighter blue">jQuery dataTables</h3>
		<div class="table-header">
			Results for "Latest Registered Domains"
		</div>
		<div class="table-responsive">
			<table id="sample-table-2" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</th>
						<th>Domain</th>
						<th>Price</th>
						<th class="hidden-480">Clicks</th>

						<th>
							<i class="icon-time bigger-110 hidden-480"></i>
							Update
						</th>
						<th class="hidden-480">Status</th>

						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
						
						require_once '../../config.php';
						require_once '../../include/medoo.min.php';
						$cols=array('cust_id','createday','op_id');
						$database = new medoo($db_path);
						$datas=$database->select('sale_order_mst','*');
						foreach($datas as $data)
						{
							echo '<tr>';
							for($i=0;$i<count($cols);$i++){
								echo '<td>'.$data[$cols[$i]].'</td>';
							}							
							echo "</tr>";
						}
						
					?>
					<tr>

						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">app.com</a>
						</td>
						<td>$45</td>
						<td class="hidden-480">3,330</td>
						<td>Feb 12</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">base.com</a>
						</td>
						<td>$35</td>
						<td class="hidden-480">2,595</td>
						<td>Feb 18</td>

						<td class="hidden-480">
							<span class="label label-sm label-success">Registered</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">max.com</a>
						</td>
						<td>$60</td>
						<td class="hidden-480">4,400</td>
						<td>Mar 11</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">best.com</a>
						</td>
						<td>$75</td>
						<td class="hidden-480">6,500</td>
						<td>Apr 03</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">pro.com</a>
						</td>
						<td>$55</td>
						<td class="hidden-480">4,250</td>
						<td>Jan 21</td>

						<td class="hidden-480">
							<span class="label label-sm label-success">Registered</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">team.com</a>
						</td>
						<td>$40</td>
						<td class="hidden-480">3,200</td>
						<td>Feb 09</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">up.com</a>
						</td>
						<td>$95</td>
						<td class="hidden-480">8,520</td>
						<td>Feb 22</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">view.com</a>
						</td>
						<td>$45</td>
						<td class="hidden-480">4,100</td>
						<td>Mar 12</td>

						<td class="hidden-480">
							<span class="label label-sm label-success">Registered</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">nice.com</a>
						</td>
						<td>$38</td>
						<td class="hidden-480">3,940</td>
						<td>Feb 12</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">fine.com</a>
						</td>
						<td>$25</td>
						<td class="hidden-480">2,983</td>
						<td>Apr 01</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">good.com</a>
						</td>
						<td>$50</td>
						<td class="hidden-480">6,500</td>
						<td>Feb 02</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">great.com</a>
						</td>
						<td>$55</td>
						<td class="hidden-480">6,400</td>
						<td>Feb 24</td>

						<td class="hidden-480">
							<span class="label label-sm label-success">Registered</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">shine.com</a>
						</td>
						<td>$25</td>
						<td class="hidden-480">2,200</td>
						<td>Apr 01</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">rise.com</a>
						</td>
						<td>$42</td>
						<td class="hidden-480">3,900</td>
						<td>Feb 01</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">above.com</a>
						</td>
						<td>$35</td>
						<td class="hidden-480">3,420</td>
						<td>Mar 12</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">share.com</a>
						</td>
						<td>$30</td>
						<td class="hidden-480">3,200</td>
						<td>Feb 11</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">fair.com</a>
						</td>
						<td>$35</td>
						<td class="hidden-480">3,900</td>
						<td>Mar 26</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">year.com</a>
						</td>
						<td>$48</td>
						<td class="hidden-480">3,990</td>
						<td>Feb 15</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">day.com</a>
						</td>
						<td>$55</td>
						<td class="hidden-480">5,600</td>
						<td>Jan 29</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">light.com</a>
						</td>
						<td>$40</td>
						<td class="hidden-480">3,100</td>
						<td>Feb 17</td>

						<td class="hidden-480">
							<span class="label label-sm label-success">Registered</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">sight.com</a>
						</td>
						<td>$58</td>
						<td class="hidden-480">6,100</td>
						<td>Feb 19</td>

						<td class="hidden-480">
							<span class="label label-sm label-inverse arrowed-in">Flagged</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">right.com</a>
						</td>
						<td>$50</td>
						<td class="hidden-480">4,400</td>
						<td>Apr 01</td>

						<td class="hidden-480">
							<span class="label label-sm label-warning">Expiring</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td>
							<a href="#">once.com</a>
						</td>
						<td>$20</td>
						<td class="hidden-480">1,400</td>
						<td>Apr 04</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ">Sold</span>
						</td>

						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="icon-zoom-in bigger-130"></i>
								</a>

								<a class="green" href="#">
									<i class="icon-pencil bigger-130"></i>
								</a>

								<a class="red" href="#">
									<i class="icon-trash bigger-130"></i>
								</a>
							</div>

							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
												<span class="blue">
													<i class="icon-zoom-in bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="icon-edit bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="icon-trash bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- page specific plugin scripts -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">
	jQuery(function($) {
		var oTable1 = $('#sample-table-2').dataTable( {
		"aoColumns": [
	      { "bSortable": false },
	      null, null,null, null, null,
		  { "bSortable": false }
		] } );
	});
</script>				