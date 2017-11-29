<?php include('header.php');
if (isset($_GET['m'])) $modulo = $_GET['m'];
if (isset($_GET['t'])) $tela = $_GET['t'];
?>
    <?php
    loadJS('bower_components/Chart.js/Chart.js',true);
    loadJS('bower_components/fastclick/lib/fastclick.js',true);
    loadJS('bower_components/raphael/raphael.min.js',true);
    loadJS('bower_components/morris.js/morris.min.js',true);
    loadJS('https://www.gstatic.com/charts/loader.js',true);
   
    if ($modulo && $tela):
        loadmodulo($modulo,$tela);
    else:
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                Dashboard
                <small>Controle de Tarefas</small>
              </h1>
              <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>            
                <li class="active">Controle de Tarefas</li>
              </ol>
            </section>
    
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-6">                                                   
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Demandas por Colaborador</h3>
                
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                            </div>
                            <div class="box-body chart-responsive">
                              <div class="chart" id="demandascolaborador" style="height: 230px; position: relative;"></div>
                            </div>
                            <!-- /.box-body -->
                          </div>
        
                          <!-- DONUT CHART -->
                          <div class="box box-danger">
                            <div class="box-header with-border">
                              <h3 class="box-title">Demandas por Status</h3>
                
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                            </div>
                            <div class="box-body">
                           
                            
                              <canvas id="pieChart" style="height:230px"></canvas>
                           	  <div id="js-legend" class="chart-legend"></div>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->        
                	</div> 
                	<!-- /.col (LEFT) -->
                    
                    <div class="col-md-6">
        				<!-- LINE CHART -->
        				<div class="box box-info">
        				<div class="box-header with-border">
        				  <h3 class="box-title">Demandas por STATUS</h3>
        
        				  <div class="box-tools pull-right">
        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        					</button>
        					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        				  </div>
        				</div>
        				<div class="box-body">
        				  <div class="chart">
        				    <div id="demandasstatus" style="height: 230px;"></div>        				            					
        				  </div>
        				</div>
        				<!-- /.box-body -->
        				</div>
        				<!-- /.box -->
            
        				<!-- BAR CHART -->
        				<div class="box box-success">
        					<div class="box-header with-border">
        					  <h3 class="box-title">Bar Chart</h3>
        
        					  <div class="box-tools pull-right">
        						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        						</button>
        						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        					  </div>
        					</div>
        					<div class="box-body">
        					  <div class="chart">
        						<canvas id="barChart" style="height:230px"></canvas>
        					  </div>
        					</div>
        					<!-- /.box-body -->
        				</div>
                      <!-- /.box -->
            
                    </div>                     
            	</div>
            </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <script>
              $(function() {
            	                         	 
            	  google.charts.load("current", {packages:["corechart"]});
                  google.charts.setOnLoadCallback(drawChartStatus);
                  function drawChartStatus() {
                    var data = google.visualization.arrayToDataTable([
                    	<?php 
                    	       echo "['Status','Qtde'],";
                    	        $select = " select count(*) qtde, st.nome, st.cor  from ";
                                $qtarefa = new tarefa();
                                $qtarefa->extras_select = "  left join status st on (st.id = tarefas.id_status)
                                                            group by st.nome , st.cor ";
                                
                                $qtarefa->selecionaTudo($qtarefa,$select);         
                                while ($res = $qtarefa->retornaDados()):
                                    echo "['".$res->nome."',".$res->qtde."],";                                        
                                endwhile; 
                            ?>	                              
                    ]);
        
                    var options = {
                      title: 'Demandas por STATUS',
                      is3D : true,
                      pieHole: 0.4,
                    };
        
                    var chart = new google.visualization.PieChart(document.getElementById('demandasstatus'));
                    chart.draw(data, options);
                  }     	  	   		    

                  google.charts.load("current", {packages:["corechart"]});
                  google.charts.setOnLoadCallback(drawChartColaborador);
                  function drawChartColaborador() {
                    var data = google.visualization.arrayToDataTable([
                    	<?php 
                    	       echo "['Colaborador','Qtde'],";
                    	       $select = " select count(*) qtde, us.nome from  ";
                    	       $qtarefa = new tarefa();
                    	       $qtarefa->extras_select = "  left join status st on (st.id = tarefas.id_status)
                                                       left join usuarios us on (us.id = tarefas.id_atribuido)
                                                       group by us.nome ";
                                
                                $qtarefa->selecionaTudo($qtarefa,$select);         
                                while ($res = $qtarefa->retornaDados()):
                                    echo "['".$res->nome."',".$res->qtde."],";                                        
                                endwhile; 
                            ?>	                              
                    ]);
        
                    var options = {
                      title: 'Demandas por Colaborador',
                     
                      pieHole: 0.4,
                    };
        
                    var chart = new google.visualization.PieChart(document.getElementById('demandascolaborador'));
                    chart.draw(data, options);
                  }                    
            	});
             
              	 
          
        </script>
    <?php     
    endif;
    ?>

	
<?php //include('sidebar.php'); ?>
<?php include('footer.php'); ?>