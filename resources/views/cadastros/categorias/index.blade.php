@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Listagem - Categorias<a href="{{ route('categorias.create') }}" style="float: right" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar</a></div>

                <div class="card-body">
                         <table id="categorias-table" class="table table-striped table-bordered nowrap no-footer" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    function excluirConfirmar(id) {
        swal({
        title: "Você realmente deseja deletar o registro?",
        text: "Esta ação não pode ser revertida!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            var token = '{{ csrf_token() }}';
            var url = '{{url("/categorias/")}}/' + id;

            $.ajax({
                url: url,
                data: {_method: 'delete', _token :token, id: id},
                type: 'post',
                success: function(result) {
                    if(result.sucesso){
                        $('#categorias-table').DataTable().ajax.reload();
                    } else {
                        swal("Erro",  result.mensagem, "error");
                    }
                }
            });
        }
        });
    }

  $(function() {
        var dtRenderAcoes = function(full) {
                var acoes = '<center>';
                acoes += '<a class="btn btn-sm btn-primary mx-1" href="/categorias/'+ full.id +'/edit" title="Editar" type="button"><i class="fa fa-edit"></i></a>';
                acoes += '<button class="btn btn-sm btn-danger" onclick="excluirConfirmar('+ full.id +')" title="Excluir" type="button"><i class="fa fa-trash-o"></i></button>';
                acoes += '</center>';
            return acoes;
        }

        var url = '{{route("categorias.obter")}}';

        $('#categorias-table').DataTable( {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nome', name: 'nome'},
                {data: 'id', name:'id', render: function (data, type, full, meta) {
                    return dtRenderAcoes(full);
                }},
            ]
        } );
    });
</script>
@endpush
