<?php

use App\Http\Controllers\admin\AmbienteController;
use App\Http\Controllers\admin\Area_ConhecimentoController;
use App\Http\Controllers\admin\ManualController;
use App\Http\Controllers\admin\OrgaoController;
use App\Http\Controllers\admin\PlataformaController;
use App\Http\Controllers\admin\ProjetoController;
use App\Http\Controllers\admin\Sub_Area_ConhecimentoController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\datacenter\AppController;
use App\Http\Controllers\datacenter\BaseController;
use App\Http\Controllers\datacenter\CadastroIpController;
use App\Http\Controllers\datacenter\ClusterController;
use App\Http\Controllers\datacenter\HostController;
use App\Http\Controllers\datacenter\RedeController;
use App\Http\Controllers\datacenter\VirtualMachineController;
use App\Http\Controllers\datacenter\vlanController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [App\Http\Controllers\Page\HomeController::class, 'master'])->name('home');

Route::group(['middleware'=> ['auth']],function(){

       ///ADMIN        
    Route::prefix('admin')->namespace('App\Http\Controllers\admin')->name('admin.')->group(function(){
      //Administração da frontpage
    Route::prefix('artigos')->name('artigos.')->group(function(){
        Route::get('/index','ArtigoController@index')->name('index');         
        Route::get('/create','ArtigoController@create')->name('create');
        Route::post('/store','ArtigoController@store')->name('store');
        Route::get('/edit/{id}','ArtigoController@edit')->name('edit');
        Route::put('/update/{id}','ArtigoController@update')->name('update');
        Route::delete('/delete/{id}','ArtigoController@destroy')->name('delete');
        Route::get('/edit-capa/{id}','ArtigoController@editCapa');
        Route::put('/upload-capa/{id}','ArtigoController@uploadCapa');
        Route::post('/delete-capa/{id}','ArtigoController@deleteCapa');
        Route::get('/edit-arquivo/{id}','ArtigoController@editArquivo');
        Route::put('/upload-arquivo/{id}','ArtigoController@uploadArquivo');
        Route::delete('/delete-arquivo/{id}','ArtigoController@deleteArquivo');            
    });  

    Route::prefix('tema')->name('tema.')->group(function(){
        Route::get('/index','TemaController@index')->name('index');
        Route::post('/store','TemaController@store');
        Route::get('/edit/{id}','TemaController@edit');
        Route::put('/update/{id}','TemaController@update');
        Route::delete('/delete/{id}','TemaController@destroy');
      }); 

    Route::prefix('user')->name('user.')->group(function(){
        Route::get('/index','UserController@index')->name('index');
        Route::put('/store','UserController@store');
        Route::get('/edit/{id}','UserController@edit');
        Route::put('/update/{id}','UserController@update');
        Route::delete('/delete/{id}','UserController@destroy');
        Route::post('/moderador/{id}', 'UserController@moderadorUsuario');
        Route::post('/inativo/{id}', 'UserController@inativoUsuario');
      });      
       //fim administração da frontpage
       
        //Rotas para a view index de ambiente    
        Route::get('index-ambientes',[AmbienteController::class,'index'])->name('ambiente.index');
        Route::delete('delete-ambiente/{id}',[AmbienteController::class,'destroy']);
        Route::get('edit-ambiente/{id}',[AmbienteController::class,'edit']);
        Route::put('update-ambiente/{id}',[AmbienteController::class,'update']);
        Route::put('adiciona-ambiente',[AmbienteController::class,'store']);
    
        //Rotas para a view index de orgao    
        Route::get('index-orgao',[OrgaoController::class,'index'])->name('orgao.index');
        Route::delete('delete-orgao/{id}',[OrgaoController::class,'destroy']);
        Route::get('edit-orgao/{id}',[OrgaoController::class,'edit']);
        Route::put('update-orgao/{id}',[OrgaoController::class,'update']);
        Route::put('adiciona-orgao',[OrgaoController::class,'store']);
    
        //Rotas para a view index de plataforma    
        Route::get('index-plataforma',[PlataformaController::class,'index'])->name('plataforma.index');
        Route::delete('delete-plataforma/{id}',[PlataformaController::class,'destroy']);
        Route::get('edit-plataforma/{id}',[PlataformaController::class,'edit']);
        Route::put('update-plataforma/{id}',[PlataformaController::class,'update']);
        Route::put('adiciona-plataforma',[PlataformaController::class,'store']);    
    
        //Rotas para a view index de projeto    
        Route::get('index-projeto',[ProjetoController::class,'index'])->name('projeto.index');
        Route::delete('delete-projeto/{id}',[ProjetoController::class,'destroy']);
        Route::get('edit-projeto/{id}',[ProjetoController::class,'edit']);
        Route::put('update-projeto/{id}',[ProjetoController::class,'update']);
        Route::put('adiciona-projeto',[ProjetoController::class,'store']);    

        //Rotas para a view index de area_conhecimento
        Route::get('index-areaconhecimento',[Area_ConhecimentoController::class,'index'])->name('areaconhecimento.index');
        Route::delete('delete-areaconhecimento/{id}',[Area_ConhecimentoController::class,'destroy']);
        Route::get('edit-areaconhecimento/{id}',[Area_ConhecimentoController::class,'edit']);
        Route::put('update-areaconhecimento/{id}',[Area_ConhecimentoController::class,'update']);
        Route::put('adiciona-areaconhecimento',[Area_ConhecimentoController::class,'store']);    
    
        //Rotas para a view index de sub_area_conhecimento
        Route::get('index-subareaconhecimento',[Sub_Area_ConhecimentoController::class,'index'])->name('subareaconhecimento.index');
        Route::delete('delete-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'destroy']);
        Route::get('edit-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'edit']);
        Route::put('update-subareaconhecimento/{id}',[Sub_Area_ConhecimentoController::class,'update']);
        Route::put('adiciona-subareaconhecimento',[Sub_Area_ConhecimentoController::class,'store']);            

        //Rotas para a view index de manuais
        Route::get('index-manual',[ManualController::class,'index'])->name('manual.index');
        Route::delete('delete-manual/{id}',[ManualController::class,'destroy']);
        Route::get('edit-manual/{id}',[ManualController::class,'edit']);
        Route::put('update-manual/{id}',[ManualController::class,'update']);
        Route::put('adiciona-manual',[ManualController::class,'store']);    

        //Rotas para a uploads
        Route::get('index-file/{id}',[ManualController::class,'indexFile'])->name('index.file');
        Route::get('edit-uploadfile/{id}',[ManualController::class,'editFileUpload']);        
        Route::put('upload-file/{id}',[ManualController::class,'upload']);
        Route::delete('delete-file/{id}',[ManualController::class,'destroyFile']);
        Route::get('download-file/{id}',[ManualController::class,'downloadFile'])->name('download.file');     
        
        ///Rotas para administração do usuário   
        Route::get('index-user', [UserController::class,'index'])->name('user.index');
        Route::put('store-user',[UserController::class,'store']);
        Route::get('edit-user/{id}',[UserController::class,'edit']);
        Route::put('update-user/{id}',[UserController::class,'update']);
        Route::delete('delete-user/{id}',[UserController::class,'destroy']);
        Route::put('moderador-user/{id}', [UserController::class,'moderadorUsuario']);
        Route::put('inativo-user/{id}', [UserController::class,'inativoUsuario']);   

        });                      

        ///DATACENTER
        //Route::prefix('datacenter')->name('datacenter.')->namespace('datacenter')->group(function(){       
        Route::prefix('datacenter')->namespace('App\Http\Controllers\datacenter')->name('datacenter.')->group(function(){

          //Rotas para a view index de clusters
        Route::get('index-cluster',[ClusterController::class,'index'])->name('cluster.index');
        Route::delete('delete-cluster/{id}',[ClusterController::class,'destroy']);
        Route::get('edit-cluster/{id}',[ClusterController::class,'edit']);
        Route::put('update-cluster/{id}',[ClusterController::class,'update']);
        Route::put('adiciona-cluster',[ClusterController::class,'store']);    
        Route::put('adiciona-hostcluster',[ClusterController::class,'storehost']);
        Route::put('cluster-adiciona-vm',[ClusterController::class,'storeVM']);

        //Rotas para a view index de hosts
        Route::get('index-host/{id}',[HostController::class,'index'])->name('host.index');
        Route::delete('delete-host/{id}',[HostController::class,'destroy']);
        Route::get('edit-host/{id}',[HostController::class,'edit']);
        Route::put('update-host/{id}',[HostController::class,'update']);
        Route::put('adiciona-host',[HostController::class,'store']);

        //Rotas para a view index de vlan
        Route::get('index-vlan',[vlanController::class,'index'])->name('vlan.index');
        Route::delete('delete-vlan/{id}',[vlanController::class,'destroy']);
        Route::get('edit-vlan/{id}',[vlanController::class,'edit']);
        Route::put('update-vlan/{id}',[vlanController::class,'update']);
        Route::put('adiciona-vlan',[vlanController::class,'store']);    
        Route::put('adiciona-vlanrede',[vlanController::class,'storerede']);        

        //Rotas para a view index de rede
        Route::get('index-rede/{id}',[RedeController::class,'index'])->name('rede.index');
        Route::delete('delete-rede/{id}',[RedeController::class,'destroy']);
        Route::get('edit-rede/{id}',[RedeController::class,'edit']);
        Route::put('update-rede/{id}',[RedeController::class,'update']);
        Route::put('adiciona-rede',[RedeController::class,'store']);
        Route::put('adiciona-redeip',[RedeController::class,'storeip']);

        //Rotas para a view index de cadastro_ip
        Route::get('index-ip/{id}',[CadastroIpController::class,'index'])->name('ip.index');
        Route::delete('delete-ip/{id}',[CadastroIpController::class,'destroy']);
        Route::get('edit-ip/{id}',[CadastroIpController::class,'edit']);
        Route::put('update-ip/{id}',[CadastroIpController::class,'update']);
        Route::put('adiciona-ip',[CadastroIpController::class,'store']);
        Route::put('status-ip/{id}',[CadastroIpController::class,'status']);

         //Rotas para a view index de VirtualMachine
         Route::get('index-vm/{id}',[VirtualMachineController::class,'index'])->name('vm.index');
         Route::delete('delete-vm/{id}',[VirtualMachineController::class,'destroy']);
         Route::get('edit-vm/{id}',[VirtualMachineController::class,'edit']);
         Route::put('update-vm/{id}',[VirtualMachineController::class,'update']);
         Route::put('adiciona-vm',[VirtualMachineController::class,'store']);
         Route::get('vlan-vm/{id}/{vlid}',[VirtualMachineController::class,'VlanXVm'])->name('vm.index_vlanXvm');
         Route::put('adiciona-basededados',[VirtualMachineController::class,'storeBase']);

         //Rotas para a view index de Bases
         Route::get('index-base/{id}',[BaseController::class,'index'])->name('base.index');
         Route::delete('delete-base/{id}',[BaseController::class,'destroy']);
         Route::get('edit-base/{id}',[BaseController::class,'edit']);
         Route::put('update-base/{id}',[BaseController::class,'update']);
         Route::put('adiciona-base',[BaseController::class,'store']);         
         Route::put('armazena-app',[BaseController::class,'storeApp']);

        //Rotas para a view index de App
         Route::get('index-app/{id}',[AppController::class,'index'])->name('app.index');
         Route::delete('delete-app/{id}',[AppController::class,'destroy']);
         Route::get('edit-app/{id}',[AppController::class,'edit']);
         Route::put('update-app/{id}',[AppController::class,'update']);
         Route::put('adiciona-app',[AppController::class,'store']);
         Route::put('https-app/{id}',[AppController::class,'httpsApp']);     
         Route::patch('storesenhaapp/{id}',[AppController::class,'storesenhaapp']);
         Route::get('editsenhaapp/{id}',[AppController::class,'editsenhaapp']);
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
