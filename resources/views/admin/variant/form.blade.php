<div class="row">
    <div class="col col-md-6">    
        {!! BootForm::text(__('clara-pim::variant.reference_variant'), 'reference_variant') !!}
        {!! BootForm::text(__('clara-pim::variant.ean'), 'ean') !!}
        {!! BootForm::text(__('clara-pim::variant.stock_variant'), 'stock_variant') !!}
        
        <h4>{{ Str::plural(__('clara-pim::attribute.attribute')) }}</h4>
        <div class="box-group" id="accordion">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            @foreach ($oAttributeCategories as $oAttributeCategorie)
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->index }}" aria-expanded="false" class="collapsed">
                            {{ $oAttributeCategorie->attribute_category_trans->first()->name_attribute_category }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $loop->index }}" class="collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                        @foreach ($oAttributeCategorie->attribute as $oAttribute)
                            {!! BootForm::checkbox($oAttribute->attribute_trans->first()->name_attribute, 'attribute[]')->value($oAttribute->id_attribute) !!}
                        @endforeach
                    </div>
                </div>
            </div>                                                
            @endforeach
        </div>
    </div>
    <div class="col col-md-6">
        {!! BootForm::viewTabPane('admin.variant.text', ClaraLang::getActiveLang()) !!}
    </div>
</div>
