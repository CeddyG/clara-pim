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
                        @php $oItem->channel_text = $oItem->channel_text->keyBy('fk_lang')->toArray() @endphp

                        {!! BootForm::open()->action(route('admin.channel.update', $oItem->id_channel))->put() !!}
                        {!! BootForm::bind($oItem) !!}
                    @else
                        {!! BootForm::open()->action(route('admin.channel.store'))->post() !!}
                    @endif

                    {!! BootForm::viewTabPane('admin.channel.text', ClaraLang::getActiveLang()) !!}
                    {!! BootForm::text(__('clara-pim::channel.code_channel'), 'code_channel') !!}

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

