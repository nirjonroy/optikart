@extends('admin.master_layout')
@section('title')
<title>Product Serial </title>
@endsection
@section('admin-content')
    
    <div class="container">
  <div class="row">
    <div class="col-md-12">
        <!--<h2 class="text-center pb-3 pt-1">Drag and Droppable Cards using Laravel 6 JQuery UI Example <span class="bg-success p-1">nicesnippets.com</span></h2>-->
        <div class="row">
            <div class="col-md-5 p-3 bg-dark offset-md-1">
                <ul class="list-group shadow-lg connectedSortable" id="padding-item-drop">
                  @if(!empty($panddingItem) && $panddingItem->count())
                    @foreach($panddingItem as $key=>$value)
                      <li class="list-group-item" item-id="{{ $value->id }}">{{ $value->name }}</li>
                    @endforeach
                  @endif
                </ul>
            </div>
            <div class="col-md-5 p-3 bg-dark offset-md-1 shadow-lg complete-item">
                <ul class="list-group  connectedSortable" id="complete-item-drop">
                  @if(!empty($completeItem) && $completeItem->count())
                    @foreach($completeItem as $key=>$value)
                      <li class="list-group-item " item-id="{{ $value->id }}">{{ $value->name }}</li>
                    @endforeach
                  @endif
                </ul>
            </div>
        </div>
    </div>
  </div>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#padding-item-drop, #complete-item-drop" ).sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
    }).disableSelection();

    $( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
        var panddingArr = [];
        var completeArr = [];

        $("#padding-item-drop li").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });

        $("#complete-item-drop li").each(function( index ) {
          completeArr[index] = $(this).attr('item-id');
        });

        $.ajax({
            url: "",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {panddingArr:panddingArr,completeArr:completeArr},
            success: function(data) {
              console.log('success');
            }
        });
          
    });
  });
</script>

@endsection