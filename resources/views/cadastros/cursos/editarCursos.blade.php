@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar - Curso</div>

                    <div class="card-body">
                         <form id="formCadastro" enctype="multipart/form-data">

                        <div class="col-xs-8 col-sm-6 col-md-8 mb-3">
                                {!!Form::label('descricao', 'Nome do Curso:'); !!}
                                {!!Form::text('nome', $model->nome, array('class' => 'form-control', 'placeholder' => 'Digite o nome'));!!}
                        </div>

                        <div class="col-xs-8 col-sm-6 col-md-12 mb-3">
                            {!!Form::label('descricao', 'Descrição ddo Curso:'); !!}
                            {!!Form::textarea('descricao', $model->descricao, array('rows'=> '3', 'class' => 'form-control', 'placeholder' => 'Digite o uma descrição para o curso'));!!}
                        </div>

                        <div>
                            <input type="checkbox" value="{{ $model->ativo }}" {{ $model->ativo == 'A' ? 'checked' : ''  }} id="ativo" name="ativo">
                             <label for="Ativo">Ativo</label>
                        </div>

                        <div class="form-group">
                            <label for="image">Escolher imagem curso:</label>
                            <input id="image" type="file" name="image">
                            <img id="preview" src="{{url('storage/')}}/{{$model->image}}"  width-max="100%" height="80">
                        </div>

                        <div style="margin-top: 10px">
                                <div class="col-xs-8 col-sm-8 col-md-5">
                                <button id="btnSalvar" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>  
                                <a href="{{ route('cursos.index') }}" class="btn btn-primary"><i class="fa fa-undo"></i> Voltar</a>
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

      $('#image').on('change', function (e){

          var fileInput=this;
          if (fileInput.files[0])
          {
              var reader = new FileReader();
              reader.onload=function(e)
              {
                  $('#preview').attr('src',e.target.result);
              }
              reader.readAsDataURL(fileInput.files[0]);
          }
      });


    $("#btnSalvar").on("click", function(params) {
        var nome = $("input[name='nome']").val();
        if(nome == "") {
            swal("Preencha o nome");
            return;
        }

        var descricao = $("[name='descricao']").val();
        if(descricao == "") {
            swal("Preencha a descrição do curso");
            return;
        }

        $(this).text("Salvando...");
        $(this).attr('disabled', 'disabled');

        var url = '{{route("cursos.update", $model->id)}}';
        let ativo = $('#ativo').is(':checked');


        if (ativo == true) {
            ativo = 'A';
        }else{
            ativo = 'I';
        }


        var formData = new FormData();
        formData.append("nome", nome);
        formData.append("descricao", descricao);
        formData.append("ativo", ativo);
        formData.append("image", $('#image')[0].files[0]);
        formData.append("_method", 'PUT');


        $.ajax({
            type: 'POST',
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,

            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            success:function(data){
                if(data.sucesso) {
                    window.location.href = '{{route("cursos.index")}}';
                } else {
                    swal("Erro", data.mensagem, "error");
                }
            }
        });
    });
  });
</script>
@endpush
