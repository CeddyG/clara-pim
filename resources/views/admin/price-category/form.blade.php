@extends('admin/dashboard')



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
                        @php $oItem->price_category_text = $oItem->price_category_text->keyBy('fk_lang')->toArray() @endphp

                        {!! BootForm::open()->action(route('admin.price-category.update', $oItem->id_price_category))->put() !!}
                        {!! BootForm::bind($oItem) !!}
                    @else
                        {!! BootForm::open()->action(route('admin.price-category.store'))->post() !!}
                    @endif

                    {!! BootForm::viewTabPane('admin.price-category.text', ClaraLang::getActiveLang()) !!}

                    {!! BootForm::submit('Envoyer', 'btn-primary')->addClass('pull-right') !!}

                    {!! BootForm::close() !!}
                </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
            </a>
        </div>
    </div>
@stop

