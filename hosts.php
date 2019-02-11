<?php require_once('header.php');?>
<?php 
if (isset($_GET['host'])){
        $historyHostArray = HostDAO::getHostHistory($_GET['host']);
    }
    $arrayCritica=array();
    $arrayAlta=array();
    $arrayMedia=array();
    $arrayBaixa=array();
    $arrayInfo=array();
    $arrayTime=array();
    $arrayId=array();
    $cont=0;
    $critica=0;
    $high=0;
    $medium=0;
    $low=0;
    
function checkSeverity($param) {
    switch ($param){
        case '4':
            return array("severity"=>"Crítica","class"=>"badge badge-danger"); 
            break;
        case '3':
            return array("severity"=>"Alta","class"=>"badge badge-warning text-white bg-orange");
            break;
        case '2':
            return array("severity"=>"Média","class"=>"badge badge-warning ");
            break;
        case '1':
            return array("severity"=>"Baixa","class"=>"badge badge-success");
            break;
        case '0':
            return array("severity"=>"Info","class"=>"badge badge-info");
            break;
    
    }
    }
    
    if (isset($_GET['host'])){
        $hostVulns = HostDAO::getHostVulnerabilities($_GET['host']);
        foreach ($hostVulns as $line ) {
            
            switch ($line['severity']){
                case '4':
                    $critica+=1;
                    break;
                case '3':
                    $high+=1;
                    break;
                case '2':
                    $medium+=1;
                    break;
                case '1':
                    $low+=1;
                    break;
            }
        }
    }

    ?>
        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="GET">
                                <input class="au-input au-input--xl" type="text" name="host" placeholder="Search for hosts" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                    	<div class="row ">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Hosts Search</h2>
                                    
                                </div>
                            </div>
                        </div>
                        <canvas id="vulns" width="400" height="100"></canvas>
                        
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                
                                                <th class="text-left">Nome</th>
                                                <th class="text-right col-1 ">Severidade</th>

                                            </tr>
                                        </thead>
                                        <?php if (isset($_GET['host'])){ foreach ($hostVulns as  $arrayHost) {?>
                                        <tbody>
                                            <tr>
                                                <td class="text-left"  ><?=$arrayHost['name']?></td>
                                                <td class="text-right col-1  "><h3><span class="<?php $class = checkSeverity($arrayHost['severity']);echo $class['class'];?>"><?php $severity = checkSeverity($arrayHost['severity']);echo $severity['severity'];?></span></h3></td>                                            
                                            </tr> 
                                            
                                        </tbody>
                                        <?php $cont+=1;}}?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div> 
<script>
var ctx = document.getElementById("vulns").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
            labels: ["Crítica","Alta", "Media"],
        datasets: [{
            
            data: [<?=$critica?>,<?=$high?>,<?=$medium?>],
            backgroundColor: [
                'rgba(255, 18, 18, 0.5)',
                'rgba(255, 140, 0, 0.5)',
                'rgba(255, 255, 0, 0.5)',
            ],
            borderColor: [
            	'rgba(255, 18, 18, 1)',
                'rgba(255, 140, 0, 1)',
                'rgba(255, 255, 0, 1)',

                
            ],
            borderWidth: 10
        }]
    },
    options: {
        
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
         
 
<?php require_once('footer.php')?>
