@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar - Cursos</div>

                   <div class="card-body">
                   <form id="formCadastro" enctype="multipart/form-data">

                        <div class="col-xs-8 col-sm-6 col-md-8 mb-3">
                                {!!Form::label('descricao', 'Nome do Curso:'); !!}
                                {!!Form::text('nome', '', array('class' => 'form-control', 'placeholder' => 'Digite o nome do curso'));!!}
                        </div>


                        <div class="col-xs-8 col-sm-6 col-md-12 mb-3">
                            {!!Form::label('descricao', 'Descrição do curso:'); !!}
                            {!!Form::textarea('descricao', '', array('rows'=> '3', 'class' => 'form-control', 'placeholder' => 'Digite o uma descrição para o curso'));!!}
                        </div>

                        <div>
                            <input type="checkbox" id="ativo" name="ativo" >
                              <label for="ativo" style="font-size:18px">Curso Ativo &#128077</label>
                        </div>

                        <div class="form-group">
                            <label for="image">Escolher imagem curso:</label>
                            <input id="image" type="file" name="image">
                        </div>

                        <div class="form-group col-lg-8">
                            <strong style="margin: 5px">Selecione a Categoria do Curso:</strong>
                            <select name="categoria_id" id="categoria_id" class="form-control custom-select">
                                <option>Selecione</option>
                                @foreach($data as $categoria)
                                    <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-8 col-md-5">
                            <button id="btnSalvar" class="btn btn-success"><i class="fa fa-save"></i>Salvar</button>  
                        <a href="{{ route('cursos.index') }}" class="btn btn-primary"><i class="fa fa-undo"></i> Voltar</a>
                        </div>
                     </div>
                  </div>
           </div>
        </div>
   </div>
</div>



@endsection

@push('scripts')
<script>
  $(function() {

    $("#btnSalvar").on("click", function(params) {
        var nome = $("input[name='nome']").val();
        if(nome == "") {
            swal("Preencha o nome");
            return;
        }

        var descricao = $("textarea[name='descricao']").val();
        if(descricao == "") {
            swal("Preencha a descrição do curso");
            return;
        }


       var ativo = $('#ativo').is(':checked');
        if (ativo == true) {
            ativo = 'A';
        }else{
            ativo = 'I';
        }

        var categoria_id = $("select[name='categoria_id']").val();
        if(categoria_id == "") {
            swal("Preencha a descrição do curso");
            return;
        }

        let formData = new FormData();
        formData.append("nome", nome);
        formData.append("descricao", descricao);
        formData.append("ativo", ativo);
        formData.append("image", $('#image')[0].files[0]);
        formData.append("categoria_id", categoria_id);


        $(this).text("Salvando...");
        $(this).attr('disabled', 'disabled');

        var url = '{{route("cursos.store")}}';

        $.ajax({
            type:'POST',
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

