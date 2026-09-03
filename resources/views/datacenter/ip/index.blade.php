@extends('adminlte::page')

@section('title', 'PRODAP - Datacenter')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>


<!--index-->
<div class="container-fluid py-5">
    <div id="success_message"></div>   
            <section class="border p-4 mb-4 d-flex align-items-left">
                <form action="{{route('datacenteradmin.ip.ip.index',['id'=>$id,'color'=>$color])}}" class="form-search" method="GET">
                    <div class="col-sm-12">
                        <div class="input-group rounded">
                        <nav class="navbar navbar-expand-md navbar-light bg-light">
                            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="000.000.000.000" aria-label="Search" aria-describedby="search-addon" data-mask="099.099.099.099">
                            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background:transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                               <i class="fas fa-search"></i>
                            </button>
                            <a href="{{route('datacenteradmin.ip.create',['id' => $id,'color' => $color])}}" type="button" class="AddIPModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                               <i class="fas fa-plus"></i>
                            </a>
                            <a href="{{route('datacenteradmin.rede.rede.index',['id'=>$vlan_id,'color'=>$color])}}" data-color="{{$color}}" type="button" class="voltarmenu_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none;"><i class="fas fa-door-open"></i></a>
                        </nav>
                        </div>
                    </div>
                </form>
            </section>
        <section class="content border p-4 mb-4 d-flex">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
            <table class="table table-hover">
            <thead class="bg-{{$color}}" style="color: white">
                    <tr>                        
                        <th scope="col">IP</th>
                        <th scope="col">MAC ADDRESS</th>
                        <th scope="col">REDE</th>
                        <th scope="col">LOCALIZAÇÃO</th>
                        <th scope="col">STATUS</th>                    
                        <th scope="col">AÇÕES</th>                       
                    </tr>                    
                </thead>
                <tbody id="lista_ips">
                    <tr id="novo" style="display: none;"></tr>    
                    @forelse($cadastroIps as $ip)
                    <tr id="ip{{$ip->id}}">                        
                        <th scope="row">{{$ip->ip}}</th>
                        <td>{{$ip->mac}}</td>
                        <td><a href="{{route('datacenteradmin.rede.rede.index',['id' => $vlan_id,'color'=>$color])}}">{{$ip->rede->nome_rede}}</a></td>
                        @if($ip->orgaovinc)
                        <td class="localizacao" style="cursor: pointer; white-space: nowrap" data-html="true" data-placement="top" data-toggle="popover" title="{{$ip->descricao}}">{{$ip->orgaovinc->nome}}/{{$ip->setorvinc->sigla}}</td>
                        @else
                        <td></td>
                        @endif
                        @if($ip->status=="OCUPADO")
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="OCUPADO"></button></td>
                        @else
                        <td id="stipid{{$ip->id}}"><button type="button" data-id="{{$ip->id}}" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="LIVRE"></button></td>
                        @endif                       
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('datacenteradmin.ip.edit',['id' => $ip->id, 'redeid' => $id, 'color' => $color])}}" type="button" class="edit_ip_btn fas fa-edit" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar IP"></a>
                                <button type="button" data-id="{{$ip->id}}" data-admin="{{auth()->user()->admin}}" data-enderecoip="{{$ip->ip}}" class="delete_ip_btn fas fa-trash" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir IP"></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="nadaencontrado">
                        <td class="col-12">Nada Encontrado!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex hover justify-content-center bg-{{$color}}">
                {{$cadastroIps->links()}}                
            </div>  
        </div>
        </div>
        </div>
    </section>       
            <div>
                <button type="button" class="voltar_btn fas fa-arrow-left" style="background: transparent; border: none; white-space: nowrap;" onclick="history.back()" data-html="true" data-placement="right" data-toggle="popover" title="Voltar para REDE"></button>
            </div>
</div>
<!--Fim Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){
        //inicio delete ip
        $(document).on('click','.delete_ip_btn',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");
            var link = "{{asset('storage')}}";            
            var enderecoip = $(this).data("enderecoip");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:enderecoip,
                text: "Deseja excluir?",
                imageUrl: link+'/logoprodap.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do prodap',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                                                      
                    $.ajax({
                        url:'/datacenteradmin/ip/delete-ip/'+id,
                        type:'POST',                    
                        dataType:'json',
                        data:{
                            'id':id,
                            '_method':'DELETE',
                            '_token':CSRF_TOKEN,
                        },
                        success:function(response){
                            if(response.status==200){
                                //remove a linha tr da table html
                                $("#ip"+id).remove();
                                $("#success_message").replaceWith('<div id="success_message"></div>');
                                $("#success_message").addClass('alert alert-success');
                                $("#success_message").text(response.message);
                            }
                    } 
                });
            }                                       
        
        });                        
   
        }); 
        //fim delete ip
     
        //inicio muda o status do ip
        $(document).on('click','.status_btn',function(e){
            e.preventDefault();            
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var id = $(this).data("id");            
            var vstatus = $(this).data("status");
            var data = {
                'pstatus': vstatus,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }   
           
            $.ajax({
                type:'POST',
                dataType:'json',
                data:data,            
                url:'/datacenteradmin/ip/status-ip/'+id,
                success:function(response){
                    if(response.status==200){
                        var limita1 = "";
                        var limita2 = "";
                        if(response.ip.status=="OCUPADO"){
                            limita1 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-status="LIVRE" class="status_btn fas fa-lock" style="background: transparent; color: red; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="OCUPADO"></button></td>';
                        }else{
                            limita2 = '<td id="stipid'+response.ip.id+'"><button type="button" data-id="'+response.ip.id+'" data-status="OCUPADO" class="status_btn fas fa-lock-open" style="background: transparent; color: green; border: none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="LIVRE"></button></td>';
                        }
                        var celula = limita1+limita2;
                        $("#stipid"+id).replaceWith(celula);
                    }
                }
            });
    
        });
        //fim muda o status do ip
            ///tooltip
    $(function(){             
        $(".status_btn").tooltip();
        $(".AddIPModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_ip_btn").tooltip();
        $(".edit_ip_btn").tooltip();
        $(".voltar_btn").tooltip();
        $(".localizacao").tooltip();
    });
    ///fim tooltip


    });
    
</script>
@stop

