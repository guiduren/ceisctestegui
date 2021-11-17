@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar - Disciplina</div>

                    <div class="card-body">
                         <form id="formCadastro">

                        <div class="col-xs-8 col-sm-6 col-md-8 mb-3">
                                {!!Form::label('descricao', 'Nome da Disciplina:'); !!}
                                {!!Form::text('nome', $model->nome, array('class' => 'form-control', 'placeholder' => 'Digite o nome'));!!}
                        </div>

                        <div style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-8 col-md-5">
                            <button id="btnSalvar" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>  
                            <a href="{{ route('disciplinas.index') }}" class="btn btn-primary"><i class="fa fa-undo"></i> Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

  $(function() {

    $("#btnSalvar").on("click", function(params) {
        var nome = $("input[name='nome']").val();
        if(nome == "") {
            swal("Preencha o nome");
            return;
        }

        $(this).text("Salvando...");
        $(this).attr('disabled', 'disabled');

        var url = '/disciplinas/' + "{{$model->id}}";

        $.ajax({
            type:'PUT',
            url: url,
            data: $("#formCadastro").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                if(data.sucesso) {
                    window.location.href = '{{route("disciplinas.index")}}';
                } else {
                    swal("Erro", data.mensagem, "error");
                }
            }
        });
    });
  });
</script>
@endpush
