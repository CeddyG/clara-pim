@extends('admin/dashboard')

@section('CSS')
    <!-- DataTables -->
    {!! Html::style('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
    
    <!-- Select 2 -->
    {!! Html::style('bower_components/select2/dist/css/select2.min.css') !!}

    <style>
        .input-group-addon:hover
        {
            color: black;
        }
        
        .select2
        {
            width: 100% !important;
        }
    </style>
    
    <!-- FileInput -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    
    <!-- Variant image -->
    <style>
        input[type="checkbox"][id^="image-variant"] {
            display: none;
        }

        .label-img-variant {
          border: 1px solid #fff;
          padding: 10px;
          display: block;
          position: relative;
          margin: 10px;
          cursor: pointer;
        }

        .label-img-variant:before {
          background-color: white;
          color: white;
          content: " ";
          display: block;
          border-radius: 50%;
          border: 1px solid grey;
          position: absolute;
          top: -5px;
          left: -5px;
          width: 25px;
          height: 25px;
          text-align: center;
          line-height: 28px;
          transition-duration: 0.4s;
          transform: scale(0);
        }

        .label-img-variant img {
          height: 100px;
          width: 100px;
          transition-duration: 0.2s;
          transform-origin: 50% 50%;
        }

        :checked + .label-img-variant {
          border-color: #ddd;
        }

        :checked + .label-img-variant:before {
          content: "✓";
          background-color: grey;
          transform: scale(1);
        }

        :checked + .label-img-variant img {
          transform: scale(0.9);
          /* box-shadow: 0 0 5px #333; */
          z-index: -1;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <br>
            <div class="box box-info">	
                <div class="box-header with-border">
                    @if(isset($oItem))
                        <h3 class="box-title">Modification</h3>
                    @else
                        <h3 class="box-title">Ajouter</h3>
                    @endif
                </div>
                <div class="box-body">
                    @if(isset($oItem))
                        @php $oItem->product_text = $oItem->product_text->keyBy('fk_lang')->toArray() @endphp

                        {!! BootForm::open()->action(route('admin.product.update', $oItem->id_product))->put() !!}
                        {!! BootForm::bind($oItem) !!}
                    @else
                        {!! BootForm::open()->action(route('admin.product.store'))->post() !!}
                    @endif
                        
                        @if(isset($oItem))
                            {!! BootForm::select(__('clara-pim::product-category.product_category'), 'fk_product_category')
                                ->class('select2 form-control')
                                ->options([$oItem->fk_product_category => $oItem->product_category->name])
                                ->data([
                                    'url-select'    => route('api.admin.product-category.select'), 
                                    'url-create'    => route('admin.product-category.create'),
                                    'field'         => 'product_category_trans.name_product_category'
                            ]) !!}
                        @else
                            {!! BootForm::select(__('clara-pim::product-category.product_category'), 'fk_product_category')
                                ->class('select2 form-control')
                                ->data([
                                    'url-select'    => route('api.admin.product-category.select'), 
                                    'url-create'    => route('admin.product-category.create'),
                                    'field'         => 'product_category_trans.name_product_category'
                            ]) !!}
                        @endif

                        {!! BootForm::viewTabPane('clara-pim::admin.product.text', ClaraLang::getActiveLang()) !!}
                        {!! BootForm::text(__('clara-pim::product.reference_product'), 'reference_product') !!}
                        {!! BootForm::BtnGroup(__('clara-pim::product.type_product'), 'type_product', [['label' => __('clara-pim::product.type_product_0'), 'value' => 0], ['label' => __('clara-pim::product.type_product_1'), 'value' => 1]]) !!}

                        {!! BootForm::submit('Envoyer', 'btn-primary')->addClass('pull-right') !!}

                    {!! BootForm::close() !!}
                </div>
            </div>
            
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Images</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <input name="file" type="file" class="file fileinput" accept="image/*" multiple>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix"></div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
            
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
            </a>
        </div>
        
        @if(isset($oItem))
            <div class="col-sm-6">
                <br>
                <div class="box box-warning">	
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ Str::plural(__('clara-pim::variant.variant')) }}</h3>
                    </div>
                    <div class="box-body"> 
                        <div class="col-12">
                            <table id="tab-variant" class="table no-margin table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('clara-pim::variant.reference_variant') }}</th>
                                        <th>{{ __('clara-pim::variant.ean') }}</th>
                                        <th>{{ __('clara-pim::variant.stock_variant') }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                
                            </table>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        {!! Button::info(__('clara::general.add'))
                            ->addAttributes(['id' => 'add-variant-btn'])
                            ->small() !!}
                    </div>
                </div>
            </div>
        
            <!-- Variant Modal -->
            <div class="modal fade" id="variant_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div id="app-store-variant" class="modal-content">
                        <form id="form-store-variant" class="form-ajax" method="POST" action="{{ route('api.admin.variant.store') }}">  
                            <input type="hidden" name="fk_product" value="{{ $oItem->id_product }}" />
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="exampleModalLongTitle">{{ __('clara-pim::variant.variant') }}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#variant_tab_1" data-toggle="tab" aria-expanded="true">{{ __('clara-pim::variant.general') }}</a></li>
                                        <li class=""><a href="#variant_tab_2" data-toggle="tab" aria-expanded="false">{{ __('clara-pim::variant.price') }}</a></li>
                                        <li class=""><a href="#variant_tab_3" data-toggle="tab" aria-expanded="false">{{ __('clara-pim::image-variant.image_variant') }}</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="variant_tab_1">
                                            @include('admin.variant.form')
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="variant_tab_2">
                                            <h4>{{ __('clara-pim::variant.sell') }}</h4>
                                            <table class="table no-margin table-bordered table-hover">
                                                <tr>
                                                    <th></th>
                                                    @foreach ($oPriceCategories as $oPriceCategorie)
                                                        <th class="text-center">{{ $oPriceCategorie->price_category_trans->first()->name_price_category }}</th>
                                                    @endforeach
                                                </tr>
                                                
                                                @foreach ($oChannels as $oChannel)
                                                <tr>
                                                    <th class="text-center">{{ $oChannel->channel_trans->first()->name_channel }} ({{ $oChannel->code_channel }})</th>
                                                    @foreach ($oPriceCategories as $oPriceCategorie)
                                                        <td>
                                                            <div class="row">
                                                                <div class="col col-sm-6">
                                                                    {!! BootForm::text(__('clara-pim::channel-price.price'), 'channel_price['.$oChannel->id_channel.']['.$oPriceCategorie->id_price_category.'][price]') !!}
                                                                </div>
                                                                <div class="col col-sm-6">
                                                                    {!! BootForm::text(__('clara-pim::channel-price.sale_price'), 'channel_price['.$oChannel->id_channel.']['.$oPriceCategorie->id_price_category.'][sale_price]') !!}
                                                                </div>
                                                            </div>                                                            
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </table>
                                            
                                            <h4>{{ __('clara-pim::variant.buy') }}</h4>
                                            <table class="table no-margin table-bordered table-hover">
                                                <tr>
                                                    <th></th>
                                                    <th>{{ __('clara-pim::variant.reference_variant') }}</th>
                                                    <th>GTIN</th>
                                                    <th>{{ __('clara-pim::variant.price') }}</th>
                                                </tr>
                                                
                                                @foreach ($oSuppliers as $oSupplier)
                                                <tr>
                                                    <th class="text-center">{{ $oSupplier->name_supplier }} ({{ $oSupplier->code_supplier }})</th>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col col-sm-6">
                                                                {!! BootForm::text('', 'variant_supplier['.$oSupplier->id_supplier.'][reference_supplier]') !!}
                                                            </div>
                                                        </div>                                                            
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col col-sm-6">
                                                                {!! BootForm::text('', 'variant_supplier['.$oSupplier->id_supplier.'][gtin]') !!}
                                                            </div>
                                                        </div>                                                            
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col col-sm-6">
                                                                {!! BootForm::text('', 'variant_supplier['.$oSupplier->id_supplier.'][buying_price]') !!}
                                                            </div>
                                                        </div>                                                            
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="variant_tab_3">
                                            <div id="variant-image" class="clearfix">
                                                
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">{{ __('clara::general.close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('clara::general.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Image Modal -->
            <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div id="app-store-variant" class="modal-content">
                        <form id="form-store-image" class="form-ajax" method="POST" action="{{ route('api.admin.image-variant.update', 'dummyId') }}">
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" id="order_image_variant" name="order_image_variant" value="" />
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ __('clara-pim::image-variant.image_variant') }}</h4>
                            </div>
                            <div class="modal-body">
                                {!! BootForm::viewTabPane('clara-pim::admin.image-variant.text', ClaraLang::getActiveLang()) !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">{{ __('clara::general.close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('clara::general.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@section('JS')    
    
    <script>
        function fillInput(key, value)
        {
            if ($('input[name*='+key+'][type=checkbox]').length > 0)
            {
                $('input[name*='+key+'][type=checkbox]').prop('checked', false);
                for (const [val, name] of Object.entries(value)) {
                    $('input[name*='+key+'][type=checkbox][value='+name+']').prop('checked', true);
                };   
            }
            else if (typeof value === 'object' && value !== null && $('#'+key).length == 0)
            {
                for (const [subkey, subvalue] of Object.entries(value)) {
                    fillInput(key+'\\['+subkey+'\\]', subvalue);
                };
            }
            else
            {
                if ($('#'+key).length > 0)
                {
                    if ($('#'+key).hasClass('ckeditor'))
                    {
                        var instance = key.replaceAll('\\', '');
                        CKEDITOR.instances[instance].setData(value);
                    }
                    else if ($('#'+key).hasClass('select2'))
                    {
                        for (const [val, name] of Object.entries(value)) {
                            var option = new Option(name, val, true, true);
                            $('#'+key).append(option);
                        };                           
                        $('#'+key).trigger('change');
                    }
                    else
                    {
                        $('#'+key).val(value);                           
                    }
                }
            }
        }
            
        $(document).ready(function() {
            //Init variant form for create or update
            $('body').on('click', '#add-variant-btn, .edit-btn', function (e) {
                var btn = $(this);
                var form = $('#form-store-variant');
                    form[0].reset();
                    
                form.find('.select2').val(null).trigger('change');
                
                if(btn.hasClass('edit-btn'))
                {
                    var urlUpdate = '{{ route('api.admin.variant.update', 'dummyId') }}';
                    urlUpdate = urlUpdate.replace('dummyId', btn.data('id'));
                    
                    form.attr('action', urlUpdate);
                    
                    if (form.find('input[name=_method]').length == 0)
                    {
                        form.prepend('<input name="_method" type="hidden" value="PUT">');
                    }
                    
                    var url = '{{ route('api.admin.variant.edit', 'dummyId') }}';
                    url = url.replace('dummyId', btn.data('id'));
                    
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {
                            'column': [
                                '*',
                                'product.image_variant.url',
                                'image_variant',
                                'variant_text',
                                'attribute.attribute_trans.name_attribute',
                                'variant_supplier',
                                'channel_price'
                            ]
                        },
                        headers: {
                            "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                        },
                        success: function(data)
                        {
                            //Format attribute
                            var attribute = [];
                            Object.keys(data.attribute).forEach(function(key) {
                                attribute.push(data.attribute[key].id_attribute);
                            });
                            data.attribute = attribute;
                            
                            //Format text
                            Object.keys(data.variant_text).forEach(function(key) {
                                data.variant_text[data.variant_text[key].fk_lang] = data.variant_text[key];
                                delete data.variant_text[key];
                            });
                            
                            //Format supplier
                            var supplier = [];
                            Object.keys(data.variant_supplier).forEach(function(key) {
                                supplier[data.variant_supplier[key].fk_supplier] = data.variant_supplier[key];
                            });
                            data.variant_supplier = supplier;
                            
                            //Format price
                            Object.keys(data.channel_price).forEach(function(key) {
                                var price = data.channel_price;
                                
                                if (data.channel_price[price[key].fk_channel] === undefined)
                                {
                                    data.channel_price[price[key].fk_channel] = [];
                                }
                                
                                data.channel_price[price[key].fk_channel][price[key].fk_price_category] = price[key];
                                delete data.channel_price[key];
                            });
                            
                            //Set image checkbox
                            $('#variant-image').html('');
                            Object.keys(data.product.image_variant).forEach(function(key) {
                                $('#variant-image').append(
                                    '<div class="file-preview-frame krajee-default">'+
                                    '<input type="checkbox" id="image-variant-'+key+'" name="image_variant[]" value="'+key+'" />'+
                                    '<label class="label-img-variant" for="image-variant-'+key+'">'+
                                    '<img src="'+data.product.image_variant[key].url.medium+'" />'+
                                    '</label>'+
                                    '</div>'
                                );
                        
                            });
                            
                            //Format image
                            var image_variant = [];
                            Object.keys(data.image_variant).forEach(function(key) {
                                image_variant.push(data.image_variant[key].id_image_variant);
                            });
                            data.image_variant = image_variant;
                            
                            for (const [key, value] of Object.entries(data)) {
                                fillInput(key, value);
                            };
                        }
                    });
                }
                else
                {
                    form.attr('action', '{{ route('api.admin.variant.store') }}');
                    form.find('input[name=_method]').remove();
                }
                
                $('#variant_modal').modal('show');
            });
            
            $('#form-store-variant').on('afterajax', function() {
                var table = $('#tab-variant').DataTable();
                            
                table.draw();
            });
            
            //Submiting all dynamics form via ajax
            $('body').on('submit', '.form-ajax', function(e) {

                e.preventDefault();
                
                var form = $(this);
                var url = form.attr('action');
                
                if (form.find('input[name=_method]').length)
                {
                    var type = form.find('input[name=_method]').val();
                }
                else
                {
                    var type = form.attr('method');
                }
                
                if (type != 'DELETE' || confirm('Voulez vous vraiment supprimer cette variante ?'))
                {
                    $.ajax({
                        type: type,
                        url: url,
                        headers: {
                            "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                        },
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data)
                        {
                            form.find('input').each(function(){
                                $(this).parents('.form-group').removeClass('has-error');
                                $(this).parents('.form-group').find('.help-block').each(function(){
                                    $(this).remove();
                                });
                            });
                            
                            form.trigger('afterajax', data);
                            
                            form.parents('.modal').modal('hide');
                        },
                        error: function(data)
                        {
                            form.find('input').each(function(){
                                $(this).parents('.form-group').removeClass('has-error');
                                $(this).parents('.form-group').find('.help-block').each(function(){
                                    $(this).remove();
                                });
                            });

                            for (const [key, value] of Object.entries(data.responseJSON.errors)) {
                                if ($('#'+key).length > 0)
                                {
                                    $('#'+key).parents('.form-group').addClass('has-error');
                                    $('#'+key).parents('.form-group').append('<p class="help-block">'+value+'</p>');
                                }
                            };
                        }
                    });
                }
            });
        });
    </script>
    
    @if(isset($oItem))
    <!-- FileInput -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/plugins/sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/locales/{{ App::getLocale() }}.js"></script>
    
    <script>
        var editButton = '<button type="button" class="kv-cust-btn btn btn-sm btn-kv btn-default btn-outline-secondary" title="Edit"{dataKey}>' +
            '<i class="fa fa-edit"></i>' +
            '</button>';
    
        var fileInputOptions = {
            language: '{{ App::getLocale() }}',
            uploadUrl: '{{ route('api.admin.image-variant.store') }}',
            uploadExtraData: {
                fk_product: {{ $oItem->id_product }}
            },
            ajaxSettings: {
                headers: {
                    'Authorization': 'Bearer {{ Sentinel::getUser()->api_token }}'
                }
            },
            ajaxDeleteSettings: {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer {{ Sentinel::getUser()->api_token }}'
                }
            },
            enableResumableUpload: true,
            showClose: false,
            overwriteInitial: false,
            initialPreviewAsData: true,
            showUpload: false, // hide upload button
            showRemove: false, // hide remove button
            otherActionButtons: editButton,
            initialPreview: [
                @foreach ($oItem->image_variant as $oImage)
                    '{{ $oImage->url['medium'] }}',
                @endforeach
            ],
            initialPreviewConfig: [
                @foreach ($oItem->image_variant as $oImage)
                {
                    key: {{ $oImage->id_image_variant }},
                    caption: '{{ $oImage->name }}', 
                    downloadUrl: '{{ $oImage->url['medium'] }}',
                    url: '{{ route('api.admin.image-variant.destroy', $oImage->id_image_variant) }}',
                    filename: '{{ $oImage->url['medium'] }}',
                    size: {{ $oImage->size['medium'] }}
                },
                @endforeach
            ]                        
        };
        
        //Init image form for update
        $('body').on('click', '.kv-cust-btn', function() {
            var form = $('#form-store-image');
            var key = $(this).data('key');

            var url = '{{ route('api.admin.image-variant.edit', 'dummyId') }}';
            url = url.replace('dummyId', key);
            
            var urlUpdate = '{{ route('api.admin.image-variant.update', 'dummyId') }}';
            urlUpdate = urlUpdate.replace('dummyId', key);
            
            form.attr('action', urlUpdate);

            $.ajax({
                url: url.replace('dummyId', key),
                headers: {
                    "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                },
                async: false,
                data: {
                    column: [
                        'image_variant_text',
                    ]
                },
                success: function(data) {
                    //Format text
                    Object.keys(data.image_variant_text).forEach(function(key) {
                        data.image_variant_text[data.image_variant_text[key].fk_lang] = data.image_variant_text[key];
                        delete data.image_variant_text[key];
                    });

                    for (const [key, value] of Object.entries(data)) {
                        fillInput(key, value);
                    };
                }
            });

            $('#image_modal').modal();
        });
        
        $('#form-store-image').on('afterajax', function(e, data) {
            var url = '{{ asset('product-image/medium/dummySlug') }}';
            var preview = $('.fileinput').fileinput('getPreview');
            var text = data.input.image_variant_text[Object.keys(data.input.image_variant_text)[0]];
            
            for (var i in preview.config) 
            {
                if (preview.config[i].key == data.id)
                {
                    url = url.replace('dummySlug', text.slug_image_variant);
                    
                    preview.config[i].caption = text.name_image_variant;
                    preview.config[i].downloadUrl = url;
                    preview.config[i].filename = url;
                    
                    preview.content[i] = url;
                }
            }
            
            fileInputOptions.initialPreview = preview.content;
            fileInputOptions.initialPreviewConfig = preview.config;
            
            $('.fileinput').fileinput('destroy');
            $('.fileinput').fileinput(fileInputOptions);
        });
        
        $('.fileinput').fileinput(fileInputOptions).on("filebatchselected", function(event, files) {
            $(this).fileinput('upload');
        }).on('filesorted', function(event, params) {
            var sUrl = '{{ route('api.admin.image-variant.update', 'dummyId') }}';
            for (var i = 0; i < params.stack.length; i++)
            {
                var data = {
                    'id_image_variant': params.stack[i].key,
                    'order_image_variant': (i+1)
                };
                
                $.ajax({
                    url: sUrl.replace("dummyId", params.stack[i].key),
                    type: 'PUT',
                    headers: {
                        'Authorization': 'Bearer {{ Sentinel::getUser()->api_token }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(data)
                });
            }
        });
    </script>
    @endif
    
    {!! Html::script('bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
    
    <script>
        $('#tab-variant').DataTable({
            serverSide: true,
            ajax: {
                'url': '{{ route('api.admin.variant.index') }}',
                headers: {
                    "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                }
            },
            columns: [
                { 'data': 'id_variant' },
                { 'data': 'reference_variant' },
                { 'data': 'ean' },
                { 'data': 'stock_variant' },
                {
                    "data": "id_variant",
                    "render": function ( data, type, row, meta ) {

                        var render = "{!! Button::warning('Modifier')->addClass(['edit-btn'])->addAttributes(['data-id' => 'dummyId'])->extraSmall()->block()->render() !!}";
                        render = render.replace("dummyId", data);

                        return render;
                    }
                },
                {
                    "data": "id_variant",
                    "render": function ( data, type, row, meta ) {

                        var render = '{!! BootForm::open()->action( route("api.admin.variant.destroy", "dummyId") )->class("form-ajax")->delete() !!}'
                            +'{!! BootForm::submit("Supprimer", "btn-danger")->addClass("btn-block btn-xs") !!}'
                            +'{!! BootForm::close() !!}';
                        render = render.replace("dummyId", data);

                        return render;
                    }
                }
            ], 
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [ -1, -2 ]
                }
            ],
            "language": {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst":      "Premier",
                        "sPrevious":   "Pr&eacute;c&eacute;dent",
                        "sNext":       "Suivant",
                        "sLast":       "Dernier"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                }
        });
    </script>
    
    <!-- Select 2 -->
    {!! Html::script('bower_components/select2/dist/js/select2.full.min.js') !!}
    
    <script>
        $(document).ready(function() {
            $('.select2').wrap('<div class="input-group input-group-select2"></div>');
            $( ".input-group-select2" ).each(function () {
                var url = $(this).find('.select2').attr(('data-url-create'));
                $(this).prepend('<a href="'+ url +'" target="_blank" class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></a>');
            });
            
            $('.select2').select2({
                ajax: {
                    url: function () {
                        return $(this).attr('data-url-select');
                    },
                    headers: {
                        "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                    },
                    dataType: 'json',
                    delay: 10,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            field: $(this).attr('data-field'),
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data
                        params.page = params.page || 1;
                
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count 
                }
                        };
                    },
                    cache: true
                },
                them: 'bootstrap'
            });
        } );
    </script>
    
    {!! Html::script('bower_components/ckeditor/ckeditor.js') !!}
    
    <script>
        $(function () {
            CKEDITOR.config.extraPlugins = 'colorbutton,colordialog';
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('.ckeditor');
        });
    </script>
@stop