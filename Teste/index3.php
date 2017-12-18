<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>DevExtreme Demo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="Lib/js/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Lib/css/dx.spa.css" />
    <link rel="stylesheet" type="text/css" href="Lib/css/dx.common.css" />
    <link rel="dx-theme" data-theme="generic.light" href="Lib/css/dx.light.css" />	  
    <script src="Lib/js/dx.all.js"></script>  
    <link rel="stylesheet" type ="text/css" href ="styles.css" />
    <style>
		.dx-datagrid-headers {
				color: #ffffff !important;
				background-color: #003666 !important;
			}
								
		 <?php 
            require_once(dirname(dirname(__FILE__))."/funcoes.php");       
            $select = " SELECT distinct
                              coalesce(case
                                        	when (tarefas.data_fim >0) then null
                                        	else (select pe.cor from periodos_entrega pe where (DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)) BETWEEN pe.inter_ini and 	pe.inter_fim)
                                    end,'White') cor
                        FROM  ";
            $tarefa = new tarefa();
            $tarefa->extras_select = " union select distinct coalesce(cor,'White') cor from status ";
            
            $tarefa->selecionaTudo($tarefa,$select);
            while ($res = $tarefa->retornaDados())
            {                                             
                echo " .cls".substr($res->cor,1,strlen($res->cor))."{  background-color:".$res->cor.";  } ";
            }   
            
        
        ?>
    </style>
    
    <script type="text/javascript">
		   function bindGrid(data) {
		       $("#gridContainer").dxDataGrid({
		            dataSource: data,
		            columnChooser: 
			            {
    		             enabled : true,
    		             mode: "select"
		             	},
		            stateStoring:{
						enabled : true,
						type: "localStorage",
						storageKey: "storages"
			            }, 	
			            keyExpr: "id",
			         pager: {
				         	showPageSizeSelector : true,
				         	allowedPageSizes: [5,10,20]
				         },
		            "export": { enabled: true, fileName: "Tarefas"},
		            columns: [
		               'id',		              		               
                       'assunto',
                       'id_tipo',
                       'id_status',
                       'id_prioridade',
                       'data_cad',
                       'id_projeto',
                       'id_categoria',
                       'data_inicio',                       
                       'data_fim',
                       'id_atribuido',
                       'id_criador',
                       'data_prev_fim',
                       'atraso',
                       'categoria',
                       'projeto',
                       'status',
                       'cor',
                       'cor_linha',
                       'usr_criador',
                       'usr_atribuido',
                       'tipo',    
		                {
		      			  dataField: "acoes",
		      			  width: 100,
		      			  dataType: "string",
		      				cellTemplate: function(container, options) {
		      		        var productName = options.value;
		      		        $("<a href=\'?m=tarefas&t=incluir&id=" + options.value + "' title='Novo'><img src='images/add.png' alt='Novo cadastro' /></a>  <a href=\'?m=tarefas&t=editar&id=" + options.value + "' title='Editar'><img src='images/edit.png' alt='Editar'/></a> <a href=\'?m=tarefas&t=excluir&id=" + options.value + "'><img src='images/delete.png' alt='Excluir' /></a>")		      		       
		      		        .appendTo(container);
		      		       // container.append($("<a  href=\'?m=tarefas&t=editar&id=" + options.value + "'><img src=images/delete.png /></a>"));
		      		      }
		      			},  		      			
		            ],		            	
		    		onCellPrepared: function (e) {
		                if (e.rowType == 'data') {
		                    if (e.column.dataField == 'status')  
		                    {     
		                    	var str = e.data.cor;		                    	      	
		                    	e.cellElement.addClass("cls"+str.substr(1, 10));  
		                      
		                    }
		    				else if (e.column.dataField == 'acoes')  
		                    {                  
		                      e.cellElement.addClass("clshite");  					
		                    }
		                }
		            },  
		    		onRowPrepared: function (info) {
		    					if (info.rowType == 'data' )
		    					{				    				
			    				  var str = '';
			    				  str = info.component.cellValue(info.rowIndex,"cor_linha");
			    				  info.rowElement.addClass("cls"+str.substr(1, 10));			    					  			                      		    						
		    					}
		    				},  
		            paging: {
		                pageSize: 10
		            },
		            sorting: {
		                mode: "multiple"
		            },
		            filterRow: {
		                visible: false
		            },
		            searchPanel: {
			            visible : true
		            },
		            showBorders : true,
		            showColumnLines : true,
		            showRowLines : true,
		            allowColumnReordering: true,
		            allowColumnResizing: true,
		            groupPanel: {
		                visible: true
		            },
		            selection: {
		                mode: "single"
		            }
		        });
		} 
		$(document).ready(function () {
		var hr = new XMLHttpRequest();
		hr.open("GET", "dados_tarefas.php", true);
		hr.setRequestHeader("Content-type", "application/json");
		hr.onreadystatechange = function() {
		    if (hr.readyState == 4 && hr.status == 200) {
		        var data = JSON.parse(hr.responseText);
		        bindGrid(data.tarefas);
		    }
		 }
		 hr.send();      
		});
   </script>
</head>

<body class="dx-viewport">	
	<div class="content-wrapper">             
                <!-- Content Header (Page header) -->
    		    <section class="content-header">
    		      <h1>
    		        tarefas
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
    		        <li class="active">Listagem</li>
    		      </ol>
    		    </section>
    		    
    		     <!-- Main content -->
        		<section class="content container-fluid">                
                	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">		       
                	<div class="box">                              
                    	<div class="box-body">
                        	<div id="gridContainer" >                           		                            	
                        	</div>
            			</div><!-- /.box -->                    
            		</div><!-- /.box-body -->
            	</section> <!-- /.Main content -->           
			</div> <!-- /.content-wrapper -->
</body>
</html>