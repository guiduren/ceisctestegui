@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar - Aula</div>

                    <div class="card-body">
                         <form id="formCadastro">

                        <div class="col-xs-8 col-sm-6 col-md-8 mb-3">
                                {!!Form::label('descricao', 'Nome da Aula:'); !!}
                                {!!Form::text('nome', $model->nome, array('class' => 'form-control', 'placeholder' => 'Digite o nome'));!!}
                        </div>

                        <div class="col-xs-8 col-sm-6 col-md-12 mb-3">
                            {!!Form::label('descricao', 'Descrição da Aula:'); !!}
                            {!!Form::textarea('descricao', $model->descricao, array('rows'=> '3', 'class' => 'form-control', 'placeholder' => 'Digite o uma descrição para a aula'));!!}
                        </div>

                        <div class='form-group col-lg-5 col-md-4'>
                            <label class="control-label">Liberar Quando?</label>
                                <div class='input-group date' id='d_data'>
                                    <input type="date" class="form-control" id="data" name="disponivel" data-toggle="tooltip" data-placement="bottom" title=""  value="{{ $model->disponivel->format('Y-m-d') }}">
                                    <span class="input-group-addon col-lg-1"></span>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                        </div>

                             <div class="form-group col-lg-8">
                                 <strong style="margin: 5px">Selecione o curso:</strong>
                                 <select name="curso_id" id="curso_id" class="form-control custom-select">
                                     <option value="">Selecione</option>
                                     @foreach($dataa as $curso)
                                         <option {{ $model->curso_id == $curso->id ? 'selected' : '' }} value="{{$curso->id}}">{{ $curso->nome }}</option>
                                     @endforeach
                                 </select>
                             </div>


                        <div style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-8 col-md-5">
                            <button id="btnSalvar" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>  
                            <a href="{{ route('aulas.index') }}" class="btn btn-primary"><i class="fa fa-undo"></i> Voltar</a>
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

        var descricao = $("input[name='descricao']").val();
        if(descricao == "") {
            swal("Preencha a descrição do curso");
            return;
        }

        var disponivel = $("input[name='disponivel']").val();
        if(disponivel == "") {
            swal("Preencha uma data para a liberação da aula");
            return;
        }

        var curso_id = $("input[name='curso_id']").val();
        if(curso_id == "") {
            swal("Preencha a qual curso essa aula pertence");
            return;
        }


        $(this).text("Salvando...");
        $(this).attr('disabled', 'disabled');

        var url = '/aulas/' + "{{$model->id}}";


        $.ajax({
            type:'PUT',
            url: url,
            data: $("#formCadastro").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                if(data.sucesso) {
                    window.location.href = '{{route("aulas.index")}}';
                } else {
                    swal("Erro", data.mensagem, "error");
                }
            }
        });
    });
  });
</script>
@endpush
