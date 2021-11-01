@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cadastrar - Usuário</div>

                <div class="card-body">
                    <form id="formCadastro">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                {!!Form::label('descricao', 'Nome'); !!}
                                {!!Form::text('name', $model->name, array('class' => 'form-control', 'placeholder' => 'Digite o nome'));!!}
                            </div>   
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                {!!Form::label('descricao', 'E-mail'); !!}
                                {!!Form::email('email', $model->email, array('class' => 'form-control', 'placeholder' => 'Digite o e-mail'));!!}
                            </div> 
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                {!!Form::label('descricao', 'Senha'); !!}
                                <input id="password" value="{{ $model->password }}" type="password" class="form-control" placeholder="Digite a senha" name="password" required>
                            </div>     
                        </div> 
    
                        <div class="row" style="margin-top: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button id="btnSalvar" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>  
                                <a href="{{ route('usuarios.index') }}" class="btn btn-primary"><i class="fa fa-undo"></i> Voltar</a>
                            </div>
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
        var nome = $("input[name='name']").val();
        if(nome == "") {
            swal("Preencha o nome");
            return;
        }

        var email = $("input[name='email']").val();
        if(email == "") {
            swal("Preencha o e-mail");
            return;
        }

        var password = $("input[name='password']").val();
        if(password == "") {
            swal("Preencha a senha");
            return;
        }

        $(this).text("Salvando...");
        $(this).attr('disabled', 'disabled');

        var url = '/usuarios/' + "{{$model->id}}";
        $.ajax({
            type:'PUT',
            url: url,
            data: $("#formCadastro").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                if(data.sucesso) {
                    window.location.href = '{{route("usuarios.index")}}';
                } else {
                    swal("Erro", data.mensagem, "error");
                }
            }
        });
    });
  });
</script>
@endpush