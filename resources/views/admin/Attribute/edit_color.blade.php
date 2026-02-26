<div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title"> Edit Color </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">

                    <form action="{{ route('admin.update-color',[$item->id]) }}" method="POST" id="color_form">
                        @csrf

                        <div class="form-group">
                              <input type="text" style="margin-bottom: 5px;" class="form-control" name="name" value="{{ $item->name }}" placeholder="Color">
                              <!--<input type="text" name="code" value="{{ $item->code }}" class="form-control" placeholder="Color code">-->
                              <!--<br>-->
                              <input type="color" name="code" placeholder="Color code">
                        </div>

                        <button class="btn btn-primary" type="submit">{{__('admin.Save')}}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>