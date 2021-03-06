@extends('admin/dashboard')

@section('CSS')
    <!-- DataTables -->
    {!! Html::style('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        @if(session()->has('ok'))

            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>

        @endif

        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Liste</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="tab-admin" class="table no-margin table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('clara-pim::channel-text.name_channel') }}</th>
                        <th>{{ __('clara-pim::channel.code_channel') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                {!! Button::info('Ajouter')->asLinkTo(route('admin.channel.create'))->small() !!}
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@section('JS')
    {!! Html::script('bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
    
    <script>
        $(document).ready(function() {
            $('#tab-admin').DataTable({
                serverSide: true,
                ajax: {
                    'url': '{{ route('api.admin.channel.index') }}',
                    headers: {
                        "Authorization": "Bearer {{ Sentinel::getUser()->api_token }}"
                    }
                },
                columns: [
                    { 'data': 'id_channel' },
                    { 
                        'data': 'channel_name',
                        'name': 'channel_trans.name_channel'
                    },
                    { 'data': 'code_channel' },
                    {
                        "data": "id_channel",
                        "render": function ( data, type, row, meta ) {

                            var render = "{!! Button::warning('Modifier')->asLinkTo(route('admin.channel.edit', 'dummyId'))->extraSmall()->block()->render() !!}";
                            render = render.replace("dummyId", data);

                            return render;
                        }
                    },
                    {
                        "data": "id_channel",
                        "render": function ( data, type, row, meta ) {

                            var render = '{!! BootForm::open()->action( route("admin.channel.destroy", "dummyId") )->attribute("onsubmit", "return confirm(\'Vraiment supprimer cet objet ?\')")->delete() !!}'
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
        });
    </script>
@endsection
