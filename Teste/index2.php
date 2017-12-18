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
    <script type="text/javascript">
		   function bindGrid(data) {
		       $("#gridContainer").dxDataGrid({
		            dataSource: data,
		            columns: [
		                'id',
		                'nome',
		                {
		      			  dataField: "id",
		      			  width: 100,
		      			  dataType: "string",
		      				cellTemplate: function(container, options) {
		      		        var productName = options.value;
		      		        $("<a href=\'?m=tipos&t=incluir&id=" + options.value + "' title='Novo'><img src='images/add.png' alt='Novo cadastro' /></a>  <a href=\'?m=tipos&t=editar&id=" + options.value + "' title='Editar'><img src='images/edit.png' alt='Editar'/></a> <a href=\'?m=tipos&t=excluir&id=" + options.value + "'><img src='images/delete.png' alt='Excluir' /></a>")		      		       
		      		        .appendTo(container);
		      		       // container.append($("<a  href=\'?m=tipos&t=editar&id=" + options.value + "'><img src=images/delete.png /></a>"));
		      		      }
		      			}
		            ],
		            paging: {
		                pageSize: 200
		            },
		            sorting: {
		                mode: "multiple"
		            },
		            filterRow: {
		                visible: true
		            },
		            allowColumnReordering: true,
		            allowColumnResizing: true,
		            groupPanel: {
		                visible: true
		            },
		            selection: {
		                mode: "no"
		            }
		        });
		} 
		$(document).ready(function () {
		var hr = new XMLHttpRequest();
		hr.open("GET", "connsql.php", true);
		hr.setRequestHeader("Content-type", "application/json");
		hr.onreadystatechange = function() {
		    if (hr.readyState == 4 && hr.status == 200) {
		        var data = JSON.parse(hr.responseText);
		        bindGrid(data.tipos);
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
    		        Tipos
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> Tipos</a></li>
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