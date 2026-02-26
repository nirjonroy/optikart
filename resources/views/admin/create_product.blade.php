@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Products')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Create Product')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Create Product')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Products')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>{{__('admin.Thumbnail Image Preview')}}</label>
                                    <div>
                                        <img id="preview-img" class="admin-img" src="{{ asset('uploads/website-images/preview.png') }}" alt="">
                                    </div>

                                </div>

                                <div class="form-group col-4">
                                    <label>{{__('admin.Thumnail Image')}} <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file"  name="thumb_image" onchange="previewThumnailImage(event)">
                                </div>
                                
                                <style>
                                
                                    .preview-image {
                                        width: 70px;
                                        padding: 10px;
                                        margin-right: 5px; /* Optional: Add margin between preview images */
                                    }
                                    
                                    .preview-image-container {
                                        display: inline-block;
                                        position: relative;
                                    }
                                    
                                    .close-icon {
                                        position: absolute;
                                        top: 5px;
                                        right: 5px;
                                        font-size: 16px;
                                        color: #000;
                                        cursor: pointer; /* Add cursor pointer */
                                    }

                                </style>

                                <div class="form-group col-4">
                                    <label>upload images <span class="text-danger">*</span></label>
                                    <!--<input type="file" name="images[]" multiple>-->
                                    <input type="file" class="form-control-file"  name="images[]" onchange="previewProductImages(event)" multiple>
                                    <div id="preview-images" class="col-12 mt-3">
                                    <!-- Preview images will be displayed here -->
                                </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>{{__('admin.Name')}} <span class="text-danger">*</span><span class="text-danger" id="name_test"></span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group col-6 d-none">
                                    <label>{{__('admin.Slug')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" class="form-control"  name="slug" value="{{ old('slug') }}">
                                </div>
                                <div class="form-group col-6">
                                    <label>Video Url <span class="text-danger"></span></label>
                                    <input type="text" id="slug" class="form-control"  name="video_link" value="{{ old('video_link') }}">
                                </div>
                                <div class="form-group col-4">
                                    <label>{{__('admin.Category')}} <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control select2" id="category">
                                        <option value="">{{__('admin.Select Category')}}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label>{{__('admin.Sub Category')}}</label>
                                    <select name="sub_category" class="form-control select2" id="sub_category">
                                        <option value="">{{__('admin.Select Sub Category')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label>{{__('admin.Child Category')}}</label>
                                    <select name="child_category" class="form-control select2" id="child_category">
                                        <option value="">{{__('admin.Select Child Category')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-6">
                                    <label>{{__('admin.Brand')}} </label>
                                    <select name="brand" class="form-control select2" id="brand">
                                        <option value="">{{__('admin.Select Brand')}}</option>
                                        @foreach ($brands as $brand)
                                            <option {{ old('brand') == $brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-6">
                                    <label>{{__('admin.SKU')}} </label>
                                   <input type="text" class="form-control" name="sku">
                                </div>

                                <div class="form-group col-4">
                                    <label>{{__('admin.Price')}} <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                </div>

                                <div class="form-group col-4">
                                    <label>{{__('admin.Offer Price')}}</label>
                                   <input type="text" class="form-control" name="offer_price" value="{{ old('offer_price') }}">
                                </div>



                                <div class="form-group col-4">
                                    <label>{{__('admin.Stock Quantity')}} <span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}">
                                </div>

                              <!--<div class="col-md-12">-->
                              <!--  <div class="row">-->

                              <!--          <div class="col-md-6">-->

                              <!--                    <div class="form-group col-12">-->
                              <!--                      <label>{{__('admin.Weight')}} <span class="text-danger">*</span></label>-->
                              <!--                  <input type="text" class="form-control" name="weight" value="{{ old('weight') }}"> -->
                              <!--                  </div>-->

                              <!--          </div>-->
                              <!--    <div class="col-md-6">-->

                              <!--    <div class="form-group col-12" style="margin-bottom: 7px;">-->
                              <!--      <label></label>-->
                                  <!-- <input type="text" class="form-control" name="weight" value="{{ old('weight') }}"> -->
                              <!--  </div>-->

                              <!--<select name="measure" class="form-control form-select shadow-none" id="">-->
                              <!--              <option value="Grm">Grm</option>-->
                              <!--              <option value="Ltr">Ltr</option>-->

                              <!--</select>-->
                              <!--  </div>                                  -->

                              <!--    </div>-->

                              <!--</div>                             -->



                                <!--<div class="form-group col-12">-->
                                <!--    <label>{{__('admin.Tag')}} <span class="text-danger">*</span></label>-->
                                <!--   <input type="text" class="form-control tags" name="tags" value="{{ old('tags') }}">-->
                                <!--</div>-->



                                <!--<div class="form-group col-12">-->
                                <!--    <label>{{__('admin.Short Description')}}</label>-->
                                <!--    <textarea name="short_description" id="" cols="30" rows="5" class="summernote">{{ old('short_description') }}</textarea>-->
                                <!--</div>-->

                                <div class="form-group col-12">
                                    <label>{{__('admin.Long Description')}} <span class="text-danger">*</span></label>
                                    <textarea name="long_description" id="" cols="30" rows="5" class="summernote">{{ old('long_description') }}</textarea>
                                </div>



                                <div class="form-group col-12 d-none">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{__('admin.Active')}}</option>
                                        <option value="0">{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>




                                <div class="form-group col-12 d-none">
                                    <label>{{__('admin.SEO Title')}}</label>
                                   <input type="text" class="form-control" name="seo_title" value="{{ old('seo_title') }}">
                                </div>

                                <div class="form-group col-12 d-none">
                                    <label>{{__('admin.SEO Description')}}</label>
                                    <textarea name="seo_description" id="" cols="30" rows="10" class="form-control text-area-5">{{ old('seo_description') }}</textarea>
                                </div>


                                <div class="col-lg-3 mb-3">
                                    <label  class="form-label">Product Size and price </label>
                                    <select name="type" id="prod_type"  class="form-control">
                                        <option value="single"> Single Size </option>
                                        <option value="variable"> Variable Size </option>
                                    </select>
                                </div>

                              <div class="col-lg-3 mb-3">
                                    <label  class="form-label">Product Color and Image </label>
                                    <select name="prod_color" id="prod_color"  class="form-control">
                                        <option value="sincolor"> Single Color </option>
                                        <option value="varcolor"> Variable Color </option>
                                    </select>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label  class="form-label">Variation Stock </label>
                                    <select name="variation_stock" id="variation_stock"  class="form-control">
                                        <option value="no"> No</option>
                                        <option value="yes"> Yes </option>
                                    </select>
                                </div>




                                <div id="hidden-specification-box" class="d-none">
                                    <div class="delete-specification-row">
                                        <div class="row mt-2">
                                            <div class="col-md-5">
                                                <label>{{__('admin.Key')}} <span class="text-danger">*</span></label>
                                                <select name="keys[]" class="form-control">
                                                    @foreach ($specificationKeys as $specificationKey)
                                                        <option value="{{ $specificationKey->id }}">{{ $specificationKey->key }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label>{{__('admin.Specification')}} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="specifications[]">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger plus_btn deleteSpeceficationBtn"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                    <div class="col-md-5">
                                         <div id="variable_table_two" class="" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-bordered text-center size_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 27%;">Size</th>
                                                    <th style="width: 30%">Price</th>

                                                    <th >Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="size_id[]" class="form-control">
                                                           
                                                            @foreach($sizes as $size)
                                                            <option {{$size->is_default==1 ?'selected':''}} value="{{$size->id}}">{{ $size->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>



                                                    <td>
                                                        <input class="variable_sell_price form-control" type="number" name="sell_price[]" placeholder="Price">
                                                    </td>



                                                    <td>
                                                        <a class="btn action-icon btn-primary add_moore" style="cursor: pointer;color: #ffffff;">Add </a>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div id="variable_table_color" class="" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-bordered text-center color_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 23%">Color</th>
                                                    <th style="width: 45%;">Image</th>

                                                    <th >Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr id="color_row">
                                                    <td>
                                                        <select name="color_id[]" class="form-control">
                                                            
                                                            @foreach($colors as $color)
                                                            <option {{$color->is_default==1 ?'selected':''}} value="{{$color->id}}">{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>



                                                    <td>
                                                        <input class="variable_product_image form-control" type="file" name="var_images[]" placeholder="Price">
                                                    </td>



                                                    <td>
                                                        <a class="btn action-icon btn-primary add_moore_color" style="cursor: pointer;color: #ffffff;">Add </a>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                    </div>

                                </div>

                                <div id="variation_quantity_table" class="col-md-12" style="display: none;">
                                    <div class="table-responsive">
                                        <label for="" class="form-label">Manage Variation Quantity</label>
                                        <table class="table table-centered table-nowrap table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th class="variation-name">Variation</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variation_quantity_body">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>


$(document).on('blur', 'input[id="name"]', function(e){
    let name = $(this).val();
    var url = "{{ route('admin.test_slug') }}";
    $.ajax({
        url,
        type: 'GET',
        dataType: "json",
        data: {name},
        success: function(res){
          if(res.status)
          {
            //   toastr.error('Name Already Exists');
              $("input#slug").val('');
              $('span#name_test').text('একই নাম পূর্বে ব্যবহার হয়েছে। সামান্য পরিবর্তন করন।');
          } else {
              $('span#name_test').text('');
          }
        }
      
    });
    
  });


// manage variation quantity start

// Track selected color and size options
let selectedColors = [];

let selectedSizes = [];

function updateVariationQuantityTable() {
    let variationQuantityTable = $('#variation_quantity_table');
    let tbody = $('#variation_quantity_body');

    // Clear existing rows
    tbody.empty();

    // Loop through each selected color and size
    let serialNumber = 1;
    selectedSizes.forEach(function (size, sizeIndex) {
    selectedColors.forEach(function (color, colorIndex) {

    let sizeValue = selectedSizesvalue[sizeIndex];
    let colorValue = selectedColorsvalue[colorIndex];

    if (color && size && sizeValue && colorValue) {
        // Create a new row
        let newRow = $('<tr>');

        // Add cells to the row
        newRow.append($('<td>').text(serialNumber++));
        newRow.append($('<td>').addClass('variation-name').text(size + '_' + color).append(
            $('<input>').addClass('form-control').attr({
                type: 'hidden',
                name: 'product_size_var_id[]',
                placeholder: 'Size id',
                value: sizeValue
            })
        ).append(
            $('<input>').addClass('form-control').attr({
                type: 'hidden',
                name: 'product_color_var_id[]',
                placeholder: 'Size id',
                value: colorValue
            })
        ));
        var isRequired = true;
        newRow.append($('<td>').append(
            $('<input>').addClass('form-control').attr({
                type: 'number',
                name: 'stock_quantity[]',
                placeholder: 'Quantity',
                value: '',
                required: isRequired,
            })
        ));

        // Append the new row to the table body
        tbody.append(newRow);
    }
});
});


    // Show the variation quantity table if variations are added
    if (serialNumber > 1) {
        variationQuantityTable.show();
    } else {
        variationQuantityTable.hide();
    }
}

// Call this function on color and size change
$(document).on('change', "select[name='color_id[]'], select[name='size_id[]']", function () {
    selectedColors = $("select[name='color_id[]']").find('option:selected').map(function () {
        return $(this).text();
    }).get();

    selectedColorsvalue = $("select[name='color_id[]']").find('option:selected').map(function () {
        return $(this).val();
    }).get();

    selectedSizes = $("select[name='size_id[]']").find('option:selected').map(function () {
        return $(this).text();
        // return $(this).val();
    }).get();

    selectedSizesvalue = $("select[name='size_id[]']").find('option:selected').map(function () {
        return $(this).val();
    }).get();

    updateVariationQuantityTable();
});

// Add more variation quantities
$(document).on('click', 'a.add_moore_color, a.add_moore', function () {
    updateVariationQuantityTable();
});

// Handle color or size removal
function handleOptionRemoval(optionType) {
    if (optionType === 'color') {
        selectedColors = $("select[name='color_id[]']").find('option:selected').map(function () {
            return $(this).text();
        }).get();
    } else if (optionType === 'size') {
        selectedSizes = $("select[name='size_id[]']").find('option:selected').map(function () {
            return $(this).text();
        }).get();
    }

    updateVariationQuantityTable();
}

// Initial call to updateVariationQuantityTable
    updateVariationQuantityTable();

// manage variation quantity end

    $(document).on('click','a.add_moore_color', function(){

            let tblrow = $(this).closest("#color_row");

            let variable_product_image = tblrow.find('td input.variable_product_image').val();

            let type=$("select[name='prod_color']").val();

            if (type=='sincolor') {
                toastr.error('For Single Product You Can\'t Add Moore');
                return;
            }
            let row=`<tr id="color_row">
                        <td>
                            <select name="color_id[]" class="form-control">
                                @foreach($colors as $color)
                                  <option {{$color->is_default==1 ?'selected':''}} value="{{$color->id}}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </td>


                        <td>

			<input class="variable_product_image form-control" type="file" name="var_images[]" placeholder="Price">

                        </td>

                        <td>
                            <a class="btn action-icon btn-primary add_moore_color" style="cursor: pointer;color: #ffffff;"> Add </a>
                            <a class="btn action-icon btn-danger remove" style="cursor: pointer;color: #ffffff;"> Delete </a>
                        </td>
                    </tr>`;
            $(document).find('.color_table tbody').append(row);

        });

    // $(document).on('change', "select[name='prod_color']", function() {
    //         let type=$("select[name='prod_color']").val();
    //         if(type == 'varcolor') {
    //             document.getElementById('variable_table_color').style.display = 'block';
    //         } else {
    //             document.getElementById('variable_table_color').style.display = 'none';
    //         }
    //     });
    
    $(document).on('change', "select[name='prod_color']", function() {
    let type = $("select[name='prod_color']").val();
    if (type == 'varcolor') {
        document.getElementById('variable_table_color').style.display = 'block';

    // Trigger 'change' event on select[name='type']
    $("select[name='type']").val('variable').trigger('change');
    $("select[name='color_id[]']").val($("select[name='color_id[]'] option:first").val()).trigger('change');
    
    var offer_price = $('input[name="offer_price"]').val();
    var price = $('input[name="price"]').val();
    
    if(offer_price != '') {
        $('div#variable_table_two input.variable_sell_price').val(offer_price);
    } else {
        $('div#variable_table_two input.variable_sell_price').val(price);
    }
    
    
    
    // Trigger 'change' event on select[name='size_id[]'] and select the first option
    $("select[name='size_id[]']").val($("select[name='size_id[]'] option:first").val()).trigger('change');
       
       
    } else {
        document.getElementById('variable_table_color').style.display = 'none';
    }
});

    (function($) {
        "use strict";
        var specification = true;
        $(document).ready(function () {
            $("#name").on("focusout",function(e){
                $("#slug").val(convertToSlug($(this).val()));
            })

            $("#category").on("change",function(){
                var categoryId = $("#category").val();
                if(categoryId){
                    $.ajax({
                        type:"get",
                        url:"{{url('/admin/subcategory-by-category/')}}"+"/"+categoryId,
                        success:function(response){
                            $("#sub_category").html(response.subCategories);
                            var response= "<option value=''>{{__('admin.Select Child Category')}}</option>";
                            $("#child_category").html(response);
                        },
                        error:function(err){
                            console.log(err);

                        }
                    })
                }else{
                    var response= "<option value=''>{{__('admin.Select Sub Category')}}</option>";
                    $("#sub_category").html(response);
                    var response= "<option value=''>{{__('admin.Select Child Category')}}</option>";
                    $("#child_category").html(response);
                }


            })

            $("#sub_category").on("change",function(){
                var SubCategoryId = $("#sub_category").val();
                if(SubCategoryId){
                    $.ajax({
                        type:"get",
                        url:"{{url('/admin/childcategory-by-subcategory/')}}"+"/"+SubCategoryId,
                        success:function(response){
                            $("#child_category").html(response.childCategories);
                        },
                        error:function(err){
                            console.log(err);

                        }
                    })
                }else{
                    var response= "<option value=''>{{__('admin.Select Child Category')}}</option>";
                    $("#child_category").html(response);
                }

            })

            $("#is_return").on('change',function(){
                var returnId = $("#is_return").val();
                if(returnId == 1){
                    $("#policy_box").removeClass('d-none');
                }else{
                    $("#policy_box").addClass('d-none');
                }

            })

            $("#addNewSpecificationRow").on('click',function(){
                var html = $("#hidden-specification-box").html();
                $("#specification-box").append(html);
            })

            $(document).on('click', '.deleteSpeceficationBtn', function () {
                $(this).closest('.delete-specification-row').remove();
            });


            $("#manageSpecificationBox").on("click",function(){
                if(specification){
                    specification = false;
                    $("#specification-box").addClass('d-none');
                }else{
                    specification = true;
                    $("#specification-box").removeClass('d-none');
                }


            })

        });
    })(jQuery);

    function convertToSlug(Text){
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-');
    }

    function previewThumnailImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview-img');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    };
    
    function previewProductImages(event) {
    var output = document.getElementById('preview-images');
    output.innerHTML = ''; // Clear previous previews

    for (var i = 0; i < event.target.files.length; i++) {
        (function (file) {
            var reader = new FileReader();
            reader.onload = function () {
                var imgContainer = document.createElement('div');
                imgContainer.className = 'preview-image-container';

                var img = document.createElement('img');
                img.src = reader.result;
                img.className = 'preview-image';
                img.style.width = '70px'; // Set the width
                img.style.padding = '10px'; // Add padding

                var closeButton = document.createElement('span');
                closeButton.className = 'close-icon';
                closeButton.innerHTML = '&times;'; // Unicode for 'times' (cross) symbol

                closeButton.onclick = function () {
                    imgContainer.remove(); // Remove the image container when close button is clicked
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(closeButton);
                output.appendChild(imgContainer);
            };

            reader.readAsDataURL(file);
        })(event.target.files[i]);
    }
}

     // add moore

        $(document).on('click','a.add_moore', function(){
            let tblrow = $(this).closest("tr");

            let variable_sell_price = tblrow.find('td input.variable_sell_price').val();
            let variable_dis_price = tblrow.find('td input.variable_dis_price').val();

            let type=$("select[name='type']").val();

            if (type=='single') {
                toastr.error('For Single Product You Can\'t Add Moore');
                return;
            }
            let row=`<tr>
                        <td>
                            <select name="size_id[]" class="form-control">
                                @foreach($sizes as $size)
                                <option value="{{$size->id}}">{{ $size->title }}</option>
                                @endforeach
                            </select>
                        </td>


                        <td>
                        <input class="variable_sell_price form-control" type="number" value="${variable_sell_price}" name="sell_price[]" placeholder="Price">
                        </td>

                        <td>
                            <a class="btn action-icon btn-primary add_moore" style="cursor: pointer;color: #ffffff;"> Add </a>
                            <a class="btn action-icon btn-danger remove" style="cursor: pointer;color: #ffffff;"> Delete </a>
                        </td>
                    </tr>`;
            $(document).find('.size_table tbody').append(row);

        });

        $(document).on('change', "select[name='type']", function() {
           
            let type=$("select[name='type']").val();
            if(type == 'variable') {
                
                var offer_price = $('input[name="offer_price"]').val();
    var price = $('input[name="price"]').val();
    
    if(offer_price != '') {
      
        $('div#variable_table_two input.variable_sell_price').val(offer_price);
    } else {
       
        $('div#variable_table_two input.variable_sell_price').val(price);
    }
                
                document.getElementById('variable_table_two').style.display = 'block';
            } else {
                document.getElementById('variable_table_two').style.display = 'none';
            }
        });

        $(document).on('change', "select[name='typecolor']", function() {
            let type=$("select[name='typecolor']").val();
            if(type == 'variableColor') {
                document.getElementById('variable_table_three').style.display = 'block';
            } else {
                document.getElementById('variable_table_three').style.display = 'none';
            }
        });

        $(document).on('click', "a.remove",function(e) {
            var whichtr = $(this).closest("tr");
            whichtr.remove();
        });

        $(document).on('blur', "input[name='sell_price']", function () {
            let sell_price = $(this).val();
            $("input.variable_sell_price").val(sell_price);
        });

        $(document).on('blur', '.dicount_amount', function(){

            let discount_amount=$(this).val();
            let new_price=0;
            var price=$("input[name='sell_price']").val();
            var discount_type=$("select[name='discount_type']").val();
            if (discount_type=='percentage') {
                new_price= (price / 100) * discount_amount;
                new_price=price - new_price;
            }else{
                new_price= price - discount_amount;
            }
            $("input[name='after_discount']").val(new_price.toFixed(2));
            $(".variable_dis_price").val(new_price.toFixed(2));
            $(".variable_dis_price_extra").val(12);
            // $(".variable_dis_price_extra").val(new_price.toFixed(2));
        });

</script>


@endsection
