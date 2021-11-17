@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Listagem - Cursos <a href="{{ route('cursos.create') }}" style="float: right;" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar</a></div>
                <div class="card-body" style="text-align: center;">

                @if(!empty($mensagem))
                    <div class="alert alert-success">
                    {{ $mensagem }}
                    </div>
                @endif
                    <table id="cursos-table" class="table table-striped table-bordered nowrap no-footer" cellspacing="0" style="width-max:100%;" enctype="multipart/form-data">
                            <thead>
                                <tr>
                                    <th>Imagem do Curso</th>
                                    <th>Código</th>
                                    <th>Categoria</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ativo</th>
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

            let url = '{{url("/cursos/")}}/' + id;

            $.ajax({
                url: url,
                data: {_method: 'delete', _token :token, id: id},
                type: 'post',
                success: function(result) {
                    if(result.sucesso){
                        $('#cursos-table').DataTable().ajax.reload();

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
                acoes += '<a class="btn btn-sm btn-primary mx-1" href="/cursos/'+ full.id +'/edit" title="Editar" type="button"><i class="fa fa-edit"></i></a>';
                acoes += '<button class="btn btn-sm btn-danger" onclick="excluirConfirmar('+ full.id +')" title="Excluir" type="button"><i class="fa fa-trash-o"></i></button>';
                acoes += '<a class="btn btn-sm btn-primary mx-1" style="margin:5px; display: flow-root;" href="/curso/'+ full.id + '" title="Página do Curso" type="button">Página do Curso</a>';
                acoes += '</center>';
            return acoes;
        }

        let url = '{{route("cursos.obter")}}';
        $('#cursos-table').DataTable( {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'image', name:'image',
                render : function (url, type, data) {
                return '<img src="{{url('storage')}}/'+ data.image +'" "width-max="100%" height="80" />';
          }},
                {data: 'categoria_id', name: 'categoria_id', render: function (data, type, full, meta) {
                        if (data==null){
                            return "Sem Categoria"
                        }
                        return full.categoria.nome;
                    }},
                {data: 'id', name: 'id'},
                {data: 'nome', name: 'nome'},
                {data: 'descricao', name: 'descricao'},
                {data: 'ativo', name: 'ativo', render: function name(data){
                    return data;
                }},
                {data: 'id', name: 'id', render: function (data, type, full, meta) {
                    return dtRenderAcoes(full);
                }},
            ]
        } );
    });
</script>
@endpush
