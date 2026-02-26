
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="demoModalLabel">Edit Home Bottom Setting</h5>
								<button type="button" class="close" data-dismiss="modal" aria-
                                label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
                            <form action="{{ route('admin.update-home-bottom', [$item->id]) }}" enctype="multipart/form-data" method="POST" id="home_bottom_setting">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input class="form-control" type="file" name="icon">
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title" value="{{ $item->title }}"> 
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input class="form-control" type="text" name="description" value="{{ $item->description }}"> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                </div>
                            </form>
						</div>

					</div>
				</div>