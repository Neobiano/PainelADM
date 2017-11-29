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
                              <h3 class="box-title">Demandas por Operador</h3>
                
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                            </div>
                            <div class="box-body chart-responsive">
                              <div class="chart" id="demandasoperador" style="height: 300px; position: relative;"></div>
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
                              <canvas id="pieChart" style="height:250px"></canvas>
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
        				  <h3 class="box-title">Line Chart</h3>
        
        				  <div class="box-tools pull-right">
        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        					</button>
        					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        				  </div>
        				</div>
        				<div class="box-body">
        				  <div class="chart">
        				    <div id="donutchart" style="height: 300px;"></div>        				    
        					
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
    	  "use strict";

		  //função para gerar cores randomicas
    	  function getRandomColor() {
              var letters = '0123456789ABCDEF'.split('');
              var color = '#';
              for (var i = 0; i < 6; i++ ) {
                  color += letters[Math.floor(Math.random() * 16)];
              }
              return color;
          }	

		  	
    	  /*MORRIS CHART*/		 
    	  // DONUT CHART
    	    
            var donut = new Morris.Donut({
              element: 'demandasoperador',
              resize: true,
              colors: ["#f56954","#00a65a","#f39c12","#3c8dbc","#d2d6de","#3c8dbc", "#f56954", "#00a65a"],
              data: [
            	  <?php 
                          $select = " select count(*) qtde, us.nome from  ";
                          $qtarefa = new tarefa();
                          $qtarefa->extras_select = "  left join status st on (st.id = tarefas.id_status)
                                                       left join usuarios us on (us.id = tarefas.id_atribuido)
                                                       group by us.nome ";
                          
                          $qtarefa->selecionaTudo($qtarefa,$select);
                          
                          while ($res = $qtarefa->retornaDados()):
                            echo  '{label: "'.$res->nome.'", value:'.$res->qtde.'},';                     
                          endwhile; 
                      ?>
              ],
              hideHover: 'auto'
            })	
    	  /* ChartJS */		  		  
    	  //-------------
    	  //- PIE CHART -
    	  //-------------
    	  // Get context with jQuery - using jQuery's .get() method.
    	  var pieChartCanvas = document.getElementById("pieChart").getContext("2d");
    	  var pieChart = new Chart(pieChartCanvas);
    	  var PieData        = [
              <?php 
                  $select = " select count(*) qtde, st.nome, st.cor  from ";
                  $qtarefa = new tarefa();
                  $qtarefa->extras_select = "  left join status st on (st.id = tarefas.id_status)
                                              group by st.nome , st.cor ";
                  
                  $qtarefa->selecionaTudo($qtarefa,$select);         
                  while ($res = $qtarefa->retornaDados()):
                      echo "{
                                  value    : ".$res->qtde.",
                                  color    : '".$res->cor."',                                  
                                  highlight: '".$res->cor."',
                                  label    : '".$res->nome."'
                                }," ;
                  endwhile; 
              ?>
           
          ]
    	  var pieOptions     = {
                  
                  //Boolean - Whether we should show a stroke on each segment
                  segmentShowStroke    : true,
                  //String - The colour of each segment stroke
                  segmentStrokeColor   : '#fff',
                  //Number - The width of each segment stroke
                  segmentStrokeWidth   : 2,
                  //Number - The percentage of the chart that we cut out of the middle
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  //Number - Amount of animation steps
                  animationSteps       : 100,
                  //String - Animation easing effect
                  animationEasing      : 'easeOutBounce',
                  //Boolean - Whether we animate the rotation of the Doughnut
                  animateRotate        : true,
                  //Boolean - Whether we animate scaling the Doughnut from the centre
                  animateScale         : true,
                  //Boolean - whether to make the chart responsive to window resizing
                  responsive           : true,
                  // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                  maintainAspectRatio  : true,
                  //String - A legend template
                   responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Doughnut Chart'
                        },
                  legendTemplate: '<ul>' + '<% for (var i=0; i<segments.length; i++) { %>' + '<li>' + '<span style=\"background-color:<%=segments[i].fillColor%>\"></span>' + '<% if (segments[i].label) { %><%= segments[i].label+": "+segments[i].value %><% } %>' + '</li>' + '<% } %>' + '</ul>'
                  //legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
    	  //Create pie or douhnut chart
    	  // You can switch between pie and douhnut using the method below.
    	  var myChart = pieChart.Doughnut(PieData, pieOptions);
    	  document.getElementById("js-legend").innerHTML = myChart.generateLegend();

    	  google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
              ['Work',     11],
              ['Eat',      2],
              ['Commute',  2],
              ['Watch TV', 2],
              ['Sleep',    7]
            ]);

            var options = {
              title: 'My Daily Activities',
              is3D : true,
              pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
          }
     	  	   

  
   
    	});
    	      
          
        </script>
    <?php     
    endif;
    ?>

	
<?php //include('sidebar.php'); ?>
<?php include('footer.php'); ?>