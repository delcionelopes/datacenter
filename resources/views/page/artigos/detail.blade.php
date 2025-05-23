@extends('layouts.page')
@section('content') 

<style>
  .card {
    transition: transform 0.2s ease;
    box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
    border-radius: 0;
    border: 0;
    margin-bottom: 1.5em;
  }
  .card:hover {
    transform: scale(1.1);
  }
</style>

  <!-- Cabeçalho-->
 <header class="masthead" style="background-image: url('/storage/{{$artigo->imagem}}')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>{{$artigo->titulo}}</h1>
                            <h2 class="subheading">{{$artigo->descricao}}</h2>
                            <span class="meta">
                                Setor {{$artigo->user->setor->sigla}} - Postado por
                                <a href="#!">{{$artigo->user->name}}</a>
                                @if($artigo->user->avatar)
                                <img src="{{asset('/storage/'.$artigo->user->avatar)}}" class="rounded-circle" width="50">
                                @else
                                <img src="../../user.png" class="rounded-circle" width="50">
                                @endif
                                <span class="caret"></span><br>                               
                                {{ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at))))}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
</header>                        
<!-- Conteúdo do artigo -->
<article class="mb-3">
            <div class="container px-1 px-lg-1">
                <div class="row gx-1 gx-lg-1 justify-content-center">
                <div class="col-md-10 col-lg-10 col-xl-9">                    
                <!--barra de informações-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-left">        
                <ul class="menu">                    
                    <li><a href="#!">Temas</a>
                        <ul>
                            @foreach($artigo->temas as $tema)
                                <li><a href="{{route('page.tema',['slug' => $tema->slug])}}">{{$tema->titulo}}</a></li>
                            @endforeach      	                  
                        </ul>
                    </li>
                    @auth
                    @if(auth()->user()->inativo!=1)
                    <li><a href="#!">Downloads</a>
                        <ul>
                            @foreach($artigo->arquivos as $arq)   
                                <li><a href="#!" id="download_file_btn" data-id="{{$arq->id}}" data-filename="{{$arq->name}}"><i class="far fa-file-pdf"></i> {{$arq->rotulo}}</a></li>	                  
                            @endforeach      
                        </ul>
                    </li>       
                    @endif
                    @endauth
                </ul>
                </nav>  
                <div class="preformated">
                        <pre style="display: block; 
                                    text-align: justify; 
                                    font-family: monospace; 
                                    white-space: pre-line;">
                           {{$artigo->conteudo}}                                                   
                        </pre>             
                </div>                
                <!-- institucionais -->    
                <div class="container-fluid">
                    <div class="row">
                    <div class="card-group">
                    @if($artigo->institucionais()->count())
                    @foreach($institucionais as $inst)
                     @foreach($artigo->institucionais as $institucional)
                     @if(($institucional->id)==($inst->id))
                    <div class="p-2 mt-2">       
                    <div class="card card-hover" style="width: 5rem;height: 5rem;">
                          <a href="{{$institucional->url_site}}" target="_blank">
                               <img class="card-img-top" src="{{asset('storage/'.$institucional->logo)}}" alt="{{$institucional->nome}}" width="100" height="100">
                           </a>                        
                     </div>
                   </div>
                    @break
                    @elseif ($loop->last)
                    {{-- cessa a construção de cards --}}
                    @endif
                    @endforeach
                    @endforeach
                    @else
                    <div class="container-fluid">
                    <div class="row">
                    <div class="p-2 mt-2">
                       <div class="card" style="width: 18rem;">
                           <div class="row no-gutters">
                              <div class="col-md-4">
                                  <img src="{{asset('logo_prodap.png')}}" class="card-img" alt="Amapá">
                              </div>
                       <div class="col-md-8">
                            <div class="card-body">
                                 <h5 class="card-title"><b>Seja bem vindo!</b></h5>
                                 <p class="card-text">Prodap!</p>
                                 <p class="card-text"><small class="text-muted">Tecnologia e transformação digital!</small></p>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    @endif
                    </div>
                    </div>
                    </div>
                <!-- fim institucionais -->
                <!--chamada dos comentários--> 
                @auth   
                <div class="col-14">             
                <button type="button" class="btn btn-primary FormCommentModal_btn animate__animated animate__bounce" data-id="{{$artigo->id}}"><i class="fas fa-heart"></i> Comentar</button>
                </div>
                @else <!--se não estiver logado-->
                <strong class="animate__animated animate__bounce">Faça Login para comentar! <i class="fas fa-comments"></i></strong>
                @endauth                                                             
                <div class="col-14">
                <hr class="my-4" /> 
                <h3>Comentários</h3>
                <hr class="my-4" />
              <table>
                <tbody id="lista_comentarios">                    
                <tr id="novo" style="display: none;"></tr>    
                @foreach($comentarios as $comentario)                                
                <tr id="comentario{{$comentario->id}}">
                <td>
                <div class="col-14">    
                    <div class="col-14">                                    
                        @if($comentario->user->avatar)    
                        <img id="avatar" src="{{asset('storage/' . $comentario->user->avatar)}}" alt="Foto de {{$comentario->user->name}}" class="rounded-circle" width="40">
                        @else                        
                        <img id="avatar" src="{{asset('storage/user.png')}}" alt="Usuário" class="rounded-circle" width="40">
                        @endif                                                                                                               
                        <small><strong>{{$comentario->user->name}}</strong></small>
                        <small class="text-muted">enviado em {{date('d/m/Y H:i:s',strtotime($comentario->created_at))}}</small>                                                
                        @auth
                        @if((auth()->user()->admin)&&(auth()->user()->inativo!=1))
                        <button data-id="{{$comentario->id}}" class="delete_comentario_btn fas fa-trash" style="background:transparent;border:none;"></button>
                        @else
                            @if(($comentario->user_id)==(auth()->user()->id))             
                            <button data-id="{{$comentario->id}}" class="delete_comentario_btn fas fa-trash" style="background:transparent;border:none;"></button>
                            @endif 
                        @endif 
                        @endauth                        
                        <p style="text-align: justify;">
                        <small>{{$comentario->texto}}</small>
                        </p>
                    </div>                
                </div>
                </td>    
                </tr>
                @endforeach 
                </tbody>                
                </table>
                <div class="d-flex justify-content-center mb-4">
                {{$comentarios->links("pagination::bootstrap-4")}}                
                </div>
                </div>                   
                <!--fim dos comentários -->
              </div>
              </div>                
            </div>            
</article> 
<!-- Rodapé-->
<footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                        <li class="list-inline-item">
                                <a href="{{asset($artigo->user->link_instagram)}}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-linkedin fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{asset($artigo->user->link_facebook)}}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{asset($artigo->user->link_site)}}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-server fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>                          
                        </ul>
                        <div class="small text-center text-muted fst-italic">copyright &copy; prodap</div>
                    </div>
                </div>
            </div>
</footer>

<!--FormCommentModal-->
<div class="modal fade animate__animated animate__bounce animate__faster" id="FormCommentModal" tabindex="-1" role="dialog" aria-labelledby="titleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar navbar-light bg-light">
                <h5 class="modal-title" id="titleLabel">Comente algo!<i class="fas fa-thumbs-up"></i></h5>                                             
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form"> 
                <input type="hidden" id="artigoid">
                <ul id="saveform_errList"></ul>                                
                <div class="form-group mb-3">
                    <label for="">Comentário</label>
                    <textarea class="comentario form-control" cols="30" rows="10"></textarea>
                </div>                                                
            </form>    
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default fechar_btn" data-dismiss="modal">Fechar</button>               
                <button type="button" class="btn btn-primary add_comment">Adicionar</button>
            </div>            
        </div>
    </div>
</div>
<!--End FormCommentModal-->
@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function(){ //INÍCIO ESCOPO GERAL
    //chamar o FormCommentModal
    $('#FormCommentModal').on('shown.bs.modal',function(){
        $('.comentario').focus();
        });

        $(document).on('click','.FormCommentModal_btn',function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $('#artigoid').val(id);            
            $('#addform').trigger('reset');
            $('#FormCommentModal').modal('show');
        });       

        $(document).on('click','.fechar_btn',function(e){
            e.preventDefault();
            $('#addform').trigger('reset');
            $('#FormCommentModal').modal('hide');
        });       
        //Fim da chamada ao FormCommentModal
        //Adicionar comentário
       $(document).on('click','.add_comment',function(e){
            e.preventDefault();
            $(this).text("Salvando...");
            var id = $('#artigoid').val();
            var data = {
                'artigoid':id,
                'comentario':$('.comentario').val(),
            }
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url:'/salvar-comentario',
                type:'POST',
                dataType:'json',
                data:data,
                success:function(response){
                 if(response.status==400){
                    $('#saveform_errList').html("");
                    $('#saveform_errList').addClass('alert alert-danger');
                    $.each(response.errors,function(key,err_values){
                        $('#saveform_errList').append('<li>'+err_values+'</li>');
                    });                        
                    $('.comentario').focus();                                               
                    $(this).text("Adicionar");
                    }else{                        
                    $(this).text("Obrigado!");
                    $('#addform').trigger('reset');
                    $('#FormCommentModal').modal('hide');
                        
var limitaComentario0 = "";    
var limitaComentario1 = "";
var limitacomentario2 = "";                        
var limitacomentario3 = "";                        
var linhaComentario = "";
var datacriacao = new Date(response.comentario.created_at);    
    datacriacao = datacriacao.toLocaleString("pt-BR");
      if(datacriacao=="31/12/1969 21:00:00"){
            datacriacao="";
      }
    limitaComentario0 = '<tr id="novo" style="display: none;"></tr>';
    limitaComentario1 = '<tr id="comentario'+response.comentario.id+'"> \
    <td> \
    <div class="col-14"> \
    <div class="col-14"> ';
    if(response.user_c.avatar!=""){                    
                  limitacomentario2 = '<img id="avatar" src="" \
                  class="rounded-circle" width="40"> ';
     }
    limitacomentario3 = '<small><strong>'+response.user_c.name+'</strong></small> \
    <small class="text-muted">enviado em '+datacriacao+'</small> \
    <button data-id ="'+response.comentario.id+'" \
    class="delete_comentario_btn fas fa-trash" \    style="background:transparent;border:none"></button> \
    <p style="text-align: justify;"> \
     <small>'+response.comentario.texto+'</small> \
     </p> \
   </div> \
   </div> \
   </td> \
   </tr>';                    
  linhaComentario = limitaComentario0+
                                    limitaComentario1+
                                    limitacomentario2+
                                    limitacomentario3;                                         
                    $('#novo').replaceWith(linhaComentario);
                    $('#avatar').attr('src','/storage/'+response.user_c.avatar);
                    }
                }	
            });
        });
//Fim Adicionar comentário
//Inicio excluir comentário	
    $(document).on('click','.delete_comentario_btn',function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                }
            });            
            $.ajax({
                url:'/delete-comentario/'+id,
                type:'POST',
                dataType:'json',
                data:{
                    "id":id,
                    "_method":'DELETE',
                },
                success:function(response){
                    if(response.status==200){
                        $('#comentario'+id).remove();
                    }
                }
            });
        });
        //Fim excluir comentário

        ////Abrir doc
    $(document).on('click','#download_file_btn',function(e){
        e.preventDefault();            
            var id = $(this).data("id"); 

               $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/admin/artigos/abrir-doc/'+id,                                
                success: function(response){ 
                    if(response.status==200){
                      var link = "{{asset('')}}"+'storage/'+response.arquivo.path;
                      //visualizar o pdf no browser                
                          window.open(link);                    
                    }
                }
            });

    });
    ///fim abrir doc   

}); //FIM ESCOPO GERAL
</script>
@endsection