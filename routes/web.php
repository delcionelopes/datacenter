<?php

use App\Http\Controllers\admin\AmbienteController;
use App\Http\Controllers\admin\Area_ConhecimentoController;
use App\Http\Controllers\admin\ArtigoController;
use App\Http\Controllers\admin\ManualController;
use App\Http\Controllers\admin\OrgaoController;
use App\Http\Controllers\admin\PlataformaController;
use App\Http\Controllers\admin\ProjetoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Caos\SetorController;
use App\Http\Controllers\admin\Sub_Area_ConhecimentoController;
use App\Http\Controllers\admin\TemaController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Caos\FuncaoController;
use App\Http\Controllers\Caos\ModuloController;
use App\Http\Controllers\Caos\OperacaoController;
use App\Http\Controllers\Caos\PerfilController;
use App\Http\Controllers\Caos\PrincipalController;
use App\Http\Controllers\Caos\SegurancaController;
use App\Http\Controllers\datacenter\AppController;
use App\Http\Controllers\datacenter\BaseController;
use App\Http\Controllers\datacenter\CadastroIpController;
use App\Http\Controllers\datacenter\ClusterController;
use App\Http\Controllers\datacenter\entidadeController;
use App\Http\Controllers\datacenter\EquipamentoController;
use App\Http\Controllers\datacenter\HostController;
use App\Http\Controllers\datacenter\institucionalController;
use App\Http\Controllers\datacenter\RedeController;
use App\Http\Controllers\datacenter\SenhaController;
use App\Http\Controllers\datacenter\VirtualMachineController;
use App\Http\Controllers\datacenter\vlanController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/home', [App\Http\Controllers\Page\HomeController::class, 'master'])->name('home');

Route::group(['middleware'=> ['auth']],function(){

       ///ADMIN        
    Route::prefix('admin')->name('admin.')->group(function(){
      //Administração da frontpage
    Route::prefix('artigos')->name('artigos.')->group(function(){
        Route::get('/index/{color}',[ArtigoController::class,'index'])->name('index');         
        Route::get('/create/{color}',[ArtigoController::class,'create'])->name('create');
        Route::post('/store',[ArtigoController::class,'store'])->name('store');
        Route::get('/edit/{id}/{color}',[ArtigoController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[ArtigoController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[ArtigoController::class,'destroy'])->name('delete');
        Route::get('/edit-capa/{id}',[ArtigoController::class,'editCapa']);
        Route::put('/upload-capa/{id}',[ArtigoController::class,'uploadCapa']);
        Route::post('/delete-capa/{id}',[ArtigoController::class,'deleteCapa']);
        Route::get('/edit-arquivo/{id}',[ArtigoController::class,'editArquivo']);
        Route::put('/upload-arquivo/{id}',[ArtigoController::class,'uploadArquivo']);
        Route::delete('/delete-arquivo/{id}',[ArtigoController::class,'deleteArquivo']);            
    });  

    Route::prefix('tema')->name('tema.')->group(function(){
        Route::get('/index/{color}',[TemaController::class,'index'])->name('index');
        Route::post('/store',[TemaController::class,'store']);
        Route::get('/edit/{id}',[TemaController::class,'edit']);
        Route::put('/update/{id}',[TemaController::class,'update']);
        Route::delete('/delete/{id}',[TemaController::class,'destroy']);
      }); 

      Route::prefix('user')->name('user.')->group(function(){
        Route::get('/index',[UserController::class,'index'])->name('index');
        Route::get('/create',[UserController::class,'create'])->name('create');
        Route::put('/store',[UserController::class,'store']);
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[UserController::class,'update']);
        Route::delete('/delete/{id}',[UserController::class,'destroy']);
        Route::put('/sistema/{id}',[UserController::class,'sistemaUsuario']);
        Route::put('/inativo/{id}', [UserController::class,'inativoUsuario']);
        Route::put('/admin/{id}', [UserController::class,'adminUsuario']);
        Route::put('/armazenar-imgtemp',[UserController::class,'armazenarImgTemp']);
        Route::delete('/delete-imgtemp',[UserController::class,'deleteImgTemp']);
      });    

      Route::prefix('entidades')->name('entidades.')->group(function(){
        Route::get('/index/{color}',[entidadeController::class,'index'])->name('index');
        Route::get('/create/{color}',[entidadeController::class,'create'])->name('create');
        Route::delete('/delete/{id}',[entidadeController::class,'destroy']);
        Route::get('/edit/{id}/{color}',[entidadeController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[entidadeController::class,'update']);
        Route::put('/store',[entidadeController::class,'store']);
        Route::put('/imagemtemp-upload',[entidadeController::class,'armazenarImagemTemporaria']);
        Route::delete('/delete-imgtemp',[entidadeController::class,'excluirImagemTemporaria']);
    });

    Route::prefix('institucionais')->name('institucionais.')->group(function(){
      Route::get('/index/{color}',[institucionalController::class,'index'])->name('index');
      Route::get('/create/{color}',[institucionalController::class,'create'])->name('create');
      Route::delete('/delete/{id}',[institucionalController::class,'destroy']);
      Route::get('/edit/{id}/{color}',[institucionalController::class,'edit'])->name('edit');
      Route::put('/update/{id}',[institucionalController::class,'update']);
      Route::put('/store',[institucionalController::class,'store']);
      Route::put('/imagemtemp-upload',[institucionalController::class,'armazenarImagemTemporaria']);
      Route::delete('/delete-imgtemp',[institucionalController::class,'excluirImagemTemporaria']);
  });
       //fim administração da frontpage

    }); //fim do grupo ADMNIN

    Route::prefix('datacenteradmin')->name('datacenteradmin.')->group(function(){

      Route::prefix('datacenter')->name('datacenter.')->group(function(){
        Route::get('/index',[HomeController::class,'index'])->name('index');
      });
      
      Route::prefix('modulo')->name('modulo.')->group(function(){
        Route::get('/index-modulo',[ModuloController::class,'index'])->name('index');
        Route::get('/create-modulo',[ModuloController::class,'create'])->name('create');
        Route::delete('/delete-modulo/{id}',[ModuloController::class,'destroy']);
        Route::get('/edit-modulo/{id}',[ModuloController::class,'edit'])->name('edit');
        Route::put('/update-modulo/{id}',[ModuloController::class,'update']);
        Route::put('/store-modulo',[ModuloController::class,'store'])->name('store');
        Route::put('/moduloimagemtemp-upload',[ModuloController::class,'armazenarImagemTemporaria']);        
        Route::delete('/delete-imgmodulo',[ModuloController::class,'excluirImagemTemporaria']);
        Route::get('/modulo-operacao/{operacao_id}',[ModuloController::class,'modulosXoperacoes'])->name('moduloxoperacao');
      }); 

      Route::prefix('operacao')->name('operacao.')->group(function(){
        Route::get('/index-operacao',[OperacaoController::class,'index'])->name('index');
        Route::get('/create-operacao',[OperacaoController::class,'create'])->name('create');
        Route::delete('/delete-operacao/{id}',[OperacaoController::class,'destroy']);
        Route::get('/edit-operacao/{id}',[OperacaoController::class,'edit'])->name('edit');
        Route::put('/update-operacao/{id}',[OperacaoController::class,'update']);
        Route::put('/store-operacao',[OperacaoController::class,'store'])->name('store');
        Route::put('/operacaoimagemtemp-upload',[OperacaoController::class,'armazenarImagemTemporaria']);        
        Route::delete('/delete-imgoperacao',[OperacaoController::class,'excluirImagemTemporaria']);
        Route::get('/operacao-modulo/{modulo_id}',[OperacaoController::class,'operacoesXmodulos'])->name('operacaoxmodulo');
      }); 

      Route::prefix('seguranca')->name('seguranca.')->group(function(){
        Route::get('/index-seguranca',[SegurancaController::class,'index_seguranca'])->name('index');
      });

      Route::prefix('principal')->name('principal.')->group(function(){   //navegação módulos autorizados
        Route::get('/index',[PrincipalController::class,'index'])->name('index'); //módulos
        Route::get('/operacoes/{id}/{color}',[PrincipalController::class,'operacoes'])->name('operacoes');  //operações
      });

      Route::prefix('funcao')->name('funcao.')->group(function(){
        Route::get('/index-funcao',[FuncaoController::class,'index'])->name('index');        
        Route::delete('/delete-funcao/{id}',[FuncaoController::class,'destroy']);
        Route::get('/edit-funcao/{id}',[FuncaoController::class,'edit'])->name('edit');
        Route::put('/update-funcao/{id}',[FuncaoController::class,'update']);
        Route::put('/store-funcao',[FuncaoController::class,'store'])->name('store');        
      }); 

      Route::prefix('setor')->name('setor.')->group(function(){
        Route::get('/index-setor/{color}',[SetorController::class,'index'])->name('index');        
        Route::delete('/delete-setor/{id}',[SetorController::class,'destroy']);
        Route::get('/edit-setor/{id}',[SetorController::class,'edit'])->name('edit');
        Route::put('/update-setor/{id}',[SetorController::class,'update']);
        Route::put('/store-setor',[SetorController::class,'store'])->name('store');        
      });
           
      Route::prefix('perfil')->name('perfil.')->group(function(){
        Route::get('/index-perfil',[PerfilController::class,'index'])->name('index');        
        Route::delete('/delete-perfil/{id}',[PerfilController::class,'destroy']);
        Route::get('/edit-perfil/{id}',[PerfilController::class,'edit'])->name('edit');
        Route::put('/update-perfil/{id}',[PerfilController::class,'update']);
        Route::put('/store-perfil',[PerfilController::class,'store'])->name('store');
        Route::get('/list-authorizations/{id}',[PerfilController::class,'listAuthorizations']);
        Route::put('/store-authorizations/{id}',[PerfilController::class,'storeAuthorizations']); 
      }); 
       
        //Rotas para a view index de ambiente
        Route::prefix('ambiente')->name('ambiente.')->group(function(){    
        Route::get('index-ambientes/{color}',[AmbienteController::class,'index'])->name('ambiente.index');
        Route::delete('delete-ambiente/{id}',[AmbienteController::class,'destroy']);
        Route::get('edit-ambiente/{id}',[AmbienteController::class,'edit']);
        Route::put('update-ambiente/{id}',[AmbienteController::class,'update']);
        Route::put('adiciona-ambiente',[AmbienteController::class,'store']);
        });
    
        //Rotas para a view index de orgao    
        Route::prefix('orgao')->name('orgao.')->group(function(){
        Route::get('index-orgao/{color}',[OrgaoController::class,'index'])->name('orgao.index');
        Route::delete('delete-orgao/{id}',[OrgaoController::class,'destroy']);
        Route::get('edit-orgao/{id}',[OrgaoController::class,'edit']);
        Route::put('update-orgao/{id}',[OrgaoController::class,'update']);
        Route::put('adiciona-orgao',[OrgaoController::class,'store']);
        });
    
        //Rotas para a view index de plataforma    
        Route::prefix('plataforma')->name('plataforma.')->group(function(){
        Route::get('index-plataforma/{color}',[PlataformaController::class,'index'])->name('plataforma.index');
        Route::delete('delete-plataforma/{id}',[PlataformaController::class,'destroy']);
        Route::get('edit-plataforma/{id}',[PlataformaController::class,'edit']);
        Route::put('update-plataforma/{id}',[PlataformaController::class,'update']);
        Route::put('adiciona-plataforma',[PlataformaController::class,'store']);    
        });
    
        //Rotas para a view index de projeto
        Route::prefix('projeto')->name('projeto.')->group(function(){    
        Route::get('index-projeto/{color}',[ProjetoController::class,'index'])->name('projeto.index');
        Route::delete('delete-projeto/{id}',[ProjetoController::class,'destroy']);
        Route::get('edit-projeto/{id}',[ProjetoController::class,'edit']);
        Route::put('update-projeto/{id}',[ProjetoController::class,'update']);
        Route::put('adiciona-projeto',[ProjetoController::class,'store']);    
        });     

        //Rotas para a view index de area_conhecimento
        Route::prefix('areaconhecimento')->name('areaconhecimento.')->group(function(){
        Route::get('index-areaconhecimento/{color}',[Area_ConhecimentoController::class,'index'])->name('areaconhecimento.index');
        Route::delete('delete-areaconhecimento/{id}',[Area_ConhecimentoController::class,'destroy']);
        Route::get('edit-areaconhecimento/{id}',[Area_ConhecimentoController::class,'edit']);
        Route::put('update-areaconhecimento/{id}',[Area_ConhecimentoController::class,'update']);
        Route::put('adiciona-areaconhecimento',[Area_ConhecimentoController::class,'store']);    
        });
    
        //Rotas para a view index de sub_area_conhecimento
        Route::prefix('subareaconhecimento')->name('subareaconhecimento.')->group(function(){
        Route::get('index-subareaconhecimento/{color}',[Sub_Area_ConhecimentoController::class,'index'])->name('subareaconhecimento.index');
        Route::delete('delete-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'destroy']);
        Route::get('edit-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'edit']);
        Route::put('update-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'update']);
        Route::put('adiciona-subareaconhecimento',[Sub_Area_ConhecimentoController::class,'store']);            
        });

        //Rotas para a view index de manuais
        Route::prefix('manual')->name('manual.')->group(function(){
        Route::get('index-manual/{color}',[ManualController::class,'index'])->name('manual.index');
        Route::delete('delete-manual/{id}',[ManualController::class,'destroy']);
        Route::get('edit-manual/{id}',[ManualController::class,'edit']);
        Route::put('update-manual/{id}',[ManualController::class,'update']);
        Route::put('adiciona-manual',[ManualController::class,'store']);    
        });

        //Rotas para a uploads
        Route::prefix('file')->name('file.')->group(function(){
        Route::get('index-file/{id}',[ManualController::class,'indexFile'])->name('index.file');
        Route::get('edit-uploadfile/{id}',[ManualController::class,'editFileUpload']);        
        Route::put('upload-file/{id}',[ManualController::class,'upload']);
        Route::delete('delete-file/{id}',[ManualController::class,'destroyFile']);
        Route::get('download-file/{id}',[ManualController::class,'downloadFile'])->name('download.file');            
        });
        
       
        //Rotas para a view index de clusters
        Route::prefix('cluster')->name('cluster.')->group(function(){  
          Route::get('index-cluster/{color}',[ClusterController::class,'index'])->name('cluster.index');
          Route::delete('delete-cluster/{id}',[ClusterController::class,'destroy']);
          Route::get('edit-cluster/{id}',[ClusterController::class,'edit']);
          Route::put('update-cluster/{id}',[ClusterController::class,'update']);
          Route::put('adiciona-cluster',[ClusterController::class,'store']);    
          Route::put('adiciona-hostcluster',[ClusterController::class,'storehost']);
          Route::put('cluster-adiciona-vm',[ClusterController::class,'storeVM']);
          });
  
          //Rotas para a view index de hosts
          Route::prefix('host')->name('host.')->group(function(){
          Route::get('index-host/{id}/{color}',[HostController::class,'index'])->name('host.index');
          Route::delete('delete-host/{id}',[HostController::class,'destroy']);
          Route::get('edit-host/{id}',[HostController::class,'edit']);
          Route::put('update-host/{id}',[HostController::class,'update']);
          Route::put('adiciona-host',[HostController::class,'store']);
          Route::patch('storesenhahost/{id}',[HostController::class,'storesenhahost']);
          Route::get('editsenhahost/{id}',[HostController::class,'editsenhahost']);
          Route::patch('updatesenhahost/{id}',[HostController::class,'updatesenhahost']);
          });        
  
          //Rotas para a view index de vlan
          Route::prefix('vlan')->name('vlan.')->group(function(){
          Route::get('index-vlan/{color}',[vlanController::class,'index'])->name('vlan.index');
          Route::delete('delete-vlan/{id}',[vlanController::class,'destroy']);
          Route::get('edit-vlan/{id}',[vlanController::class,'edit']);
          Route::put('update-vlan/{id}',[vlanController::class,'update']);
          Route::put('adiciona-vlan',[vlanController::class,'store']);    
          Route::put('adiciona-vlanrede',[vlanController::class,'storerede']);
          Route::patch('storesenhavlan/{id}',[vlanController::class,'storesenhavlan']);
          Route::get('editsenhavlan/{id}',[vlanController::class,'editsenhavlan']);
          Route::patch('updatesenhavlan/{id}',[vlanController::class,'updatesenhavlan']);  
          });
  
          //Rotas para a view index de rede
          Route::prefix('rede')->name('rede.')->group(function(){
          Route::get('index-rede/{id}/{color}',[RedeController::class,'index'])->name('rede.index');
          Route::delete('delete-rede/{id}',[RedeController::class,'destroy']);
          Route::get('edit-rede/{id}',[RedeController::class,'edit']);
          Route::put('update-rede/{id}',[RedeController::class,'update']);
          Route::put('adiciona-rede',[RedeController::class,'store']);
          Route::put('adiciona-redeip',[RedeController::class,'storeip']);
          });
  
          //Rotas para a view index de cadastro_ip
          Route::prefix('ip')->name('ip.')->group(function(){
          Route::get('index-ip/{id}/{color}',[CadastroIpController::class,'index'])->name('ip.index');
          Route::delete('delete-ip/{id}',[CadastroIpController::class,'destroy']);
          Route::get('edit-ip/{id}',[CadastroIpController::class,'edit']);
          Route::put('update-ip/{id}',[CadastroIpController::class,'update']);
          Route::put('adiciona-ip',[CadastroIpController::class,'store']);
          Route::put('status-ip/{id}',[CadastroIpController::class,'status']);
          });
  
           //Rotas para a view index de VirtualMachine
          Route::prefix('vm')->name('vm.')->group(function(){
          Route::get('index-vm/{id}/{color}',[VirtualMachineController::class,'index'])->name('vm.index');
          Route::delete('delete-vm/{id}',[VirtualMachineController::class,'destroy']);
          Route::get('edit-vm/{id}',[VirtualMachineController::class,'edit']);
          Route::put('update-vm/{id}',[VirtualMachineController::class,'update']);
          Route::put('adiciona-vm',[VirtualMachineController::class,'store']);
          Route::get('vlan-vm/{id}/{vlid}/{color}',[VirtualMachineController::class,'VlanXVm'])->name('vm.index_vlanXvm');
          Route::put('adiciona-basededados',[VirtualMachineController::class,'storeBase']);
          Route::patch('storesenhavm/{id}',[VirtualMachineController::class,'storesenhavm']);
          Route::get('editsenhavm/{id}',[VirtualMachineController::class,'editsenhavm']);
          Route::patch('updatesenhavm/{id}',[VirtualMachineController::class,'updatesenhavm']);
          });
  
           //Rotas para a view index de Bases
           Route::prefix('base')->name('base.')->group(function(){
           Route::get('index-base/{id}/{color}',[BaseController::class,'index'])->name('base.index');
           Route::delete('delete-base/{id}',[BaseController::class,'destroy']);
           Route::get('edit-base/{id}',[BaseController::class,'edit']);
           Route::put('update-base/{id}',[BaseController::class,'update']);
           Route::put('adiciona-base',[BaseController::class,'store']);         
           Route::put('armazena-app',[BaseController::class,'storeApp']);
           Route::patch('storesenhabase/{id}',[BaseController::class,'storesenhabase']);
           Route::get('editsenhabase/{id}',[BaseController::class,'editsenhabase']);
           Route::patch('updatesenhabase/{id}',[BaseController::class,'updatesenhabase']);
           });
  
          //Rotas para a view index de App
           Route::prefix('app')->name('app.')->group(function(){ 
           Route::get('index-app/{id}/{color}',[AppController::class,'index'])->name('app.index');
           Route::delete('delete-app/{id}',[AppController::class,'destroy']);
           Route::get('edit-app/{id}',[AppController::class,'edit']);
           Route::put('update-app/{id}',[AppController::class,'update']);
           Route::put('adiciona-app',[AppController::class,'store']);
           Route::put('https-app/{id}',[AppController::class,'httpsApp']);     
           Route::patch('storesenhaapp/{id}',[AppController::class,'storesenhaapp']);
           Route::get('editsenhaapp/{id}',[AppController::class,'editsenhaapp']);
           Route::patch('updatesenhaapp/{id}',[AppController::class,'updatesenhaapp']);
           });
  
           //Rotas para painel de senhas no menu principal
           Route::prefix('senhas')->name('senhas.')->group(function(){
           Route::get('index-senhas/{color}',[SenhaController::class,'index'])->name('senha.index');
           Route::get('editusersenhaapp/{id}',[SenhaController::class,'editsenhaapp']);
           Route::patch('updateusersenhaapp/{id}',[SenhaController::class,'updatesenhaapp']);
           Route::get('editusersenhahost/{id}',[SenhaController::class,'editsenhahost']);
           Route::patch('updateusersenhahost/{id}',[SenhaController::class,'updatesenhahost']);
           Route::get('editusersenhavm/{id}',[SenhaController::class,'editsenhavm']);
           Route::patch('updateusersenhavm/{id}',[SenhaController::class,'updatesenhavm']);
           Route::get('editusersenhabase/{id}',[SenhaController::class,'editsenhabase']);
           Route::patch('updateusersenhabase/{id}',[SenhaController::class,'updatesenhabase']);
           Route::get('editusersenhavlan/{id}',[SenhaController::class,'editsenhavlan']);
           Route::patch('updateusersenhavlan/{id}',[SenhaController::class,'updatesenhavlan']);  
           });
  
           //Rotas para a view index de Equipamentos
           Route::prefix('equipamento')->name('equipamento.')->group(function(){
           Route::get('index-equipamento/{color}',[EquipamentoController::class,'index'])->name('equipamento.index');
           Route::delete('delete-equipamento/{id}',[EquipamentoController::class,'destroy']);
           Route::get('edit-equipamento/{id}',[EquipamentoController::class,'edit']);
           Route::put('update-equipamento/{id}',[EquipamentoController::class,'update']);
           Route::put('adiciona-equipamento',[EquipamentoController::class,'store']);                           
           Route::get('editsenhaequipamento/{id}',[EquipamentoController::class,'editsenhaEquipamento']);
           Route::get('editsenhaindividual/{id}',[EquipamentoController::class,'editsenhaIndividual']);
           Route::patch('updatesenhaequipamento/{id}',[EquipamentoController::class,'updatesenhaEquipamento']);
           Route::patch('updatesenhaindividual/{id}',[EquipamentoController::class,'updatesenhaIndividual']);
           });

           //Relatórios
           Route::prefix('relatorios')->name('relatorios.')->group(function(){            
            Route::get('relatorio-ambientes',[AmbienteController::class,'relatorioAmbiente'])->name('relatorio.ambientes');
            Route::get('relatorio-maquinasvirtuais',[VirtualMachineController::class,'relatorioVM'])->name('relatorio.maquinasvirtuais');
            Route::get('relatorio-bases',[BaseController::class,'relatorioBD'])->name('relatorio.bases');
            Route::get('relatorio-plataformas',[PlataformaController::class,'relatorioPlataforma'])->name('relatorio.plataforma');
            Route::get('relatorio-redes',[RedeController::class,'relatorioRedes'])->name('relatorio.redes');
            Route::get('relatorio-setores',[SetorController::class,'relatorioSetores'])->name('relatorio.setores');
            Route::get('relatorio-hosts',[HostController::class,'relatorioHosts'])->name('relatorio.hosts');
            Route::get('relatorio-clusters',[ClusterController::class,'relatorioClusters'])->name('relatorio.clusters');
            Route::get('relatorio-orgaos',[OrgaoController::class,'relatorioOrgaos'])->name('relatorio.orgaos');
            Route::get('relatorio-areas',[Area_ConhecimentoController::class,'relatorioAreas'])->name('relatorio.areas');
            Route::get('relatorio-modope',[ModuloController::class,'relatorioModope'])->name('relatorio.modope');
            Route::get('relatorio-usuarios',[UserController::class,'relatorioUsuarios'])->name('relatorio.usuarios');
            Route::get('relatorio-permissoes/{id}',[ModuloController::class,'relatorioPermissoes'])->name('relatorio.permissoes');
            Route::get('relatorio-equipamentos',[EquipamentoController::class,'relatorioEquipamentos'])->name('relatorio.equipamentos');
           });

        });
                        

    }); //fim do escopo do middleware auth
    
   Route::namespace('App\Http\Controllers\Page')->name('page.')->group(function(){
    Route::get('/','HomeController@master')->name('master');
    Route::get('/artigo/{slug}','HomeController@detail')->name('detail');
    Route::get('/download-arquivo/{id}','HomeController@downloadArquivo')->name('download');
    Route::get('/tema/{slug}','TemaArtigoController@index')->name('tema');
    Route::get('/show-perfil/{id}','HomeController@showPerfil')->name('showperfil');
    Route::put('/perfil/{id}','HomeController@perfilUsuario')->name('perfil');  
    Route::post('/salvar-comentario','ComentarioController@salvarComentario');
    Route::delete('/delete-comentario/{id}','ComentarioController@deleteComentario');
    Route::get('/enviar-email/{slug}','HomeController@enviarEmail');
  });

   //acesso ao sistema do datacenter
   Route::prefix('sistema')->name('sistema.')->group(function(){
        Route::get('/index',[HomeController::class,'index'])->name('index');
        }); 
