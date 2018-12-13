<?php require_once('header.php');?>
<?php 
    $arrayCritica=array();
    $arrayAlta=array();
    $arrayMedia=array();
    $arrayBaixa=array();
    $arrayInfo=array();
    $arrayTime=array();
    $arrayId=array();
    $cont=0;
    
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
    $scan_history=ScanDAO::getScanHistory($_GET['scan_id'],$_GET['scanner_id']);
foreach ($scan_history as $history) {
    array_push($arrayCritica,$history['critical']);
    array_push($arrayAlta,$history['high']);
    array_push($arrayMedia,$history['medium']);
    array_push($arrayBaixa,$history['low']);
    array_push($arrayInfo,$history['info']);
    array_push($arrayId,$history['id']);
    array_push($arrayTime,$history['last_modification_date']);
   
}
    
    
    
    ?>
        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
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
                                    <h2 class="title-1">Scan Detail - <?=$_GET['scan_name']?></h2>
                                    <a href="scanController.php?action=sync&scan_id=<?=$_GET['scan_id']?>&scanner_id=<?=$_GET['scanner_id']?>">Sync <i class="fas fa-sync"></i></a>
                                </div>
                            </div>
                        </div>
                        <canvas id="history" width="400" height="100"></canvas>
                        <?php $vulnsArray = VulnerabilityDAO::getAllVulnerabilitiesFromScan((int)$_GET['scan_id'],(int)$_GET['scanner_id']);?>
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
                                        <?php foreach ($vulnsArray as $scan) {?>
                                        <tbody>
                                            <tr>
                                                <td class="text-left" data-toggle="collapse" data-target="#vulns<?=$cont?>"><?=$scan['name']?></td>
                                                <td class="text-right col-1  "><h3><span class="<?php $class = checkSeverity($scan['severity']);echo $class['class'];?>"><?php $severity = checkSeverity($scan['severity']);echo $severity['severity'];?></span></h3></td>                                            
                                            </tr> 
                                            <tr  class=" collapse" id="vulns<?=$cont?>">
                                            	<td colspan="2">
                                                	<?php 
                                                    	if($scan['severity']==='4'||$scan['severity']==='3'){
                                                        	$hostsVulnerable=VulnerabilityDAO::getAllHostsVulnerable((int)$_GET['scan_id'], (int)$_GET['scanner_id'], $scan['name']);
                                                        	echo "<ul>";
                                                            	foreach ($hostsVulnerable as $hostname) {
                                                            	       echo "<li>".$hostname["hostname"]."</li>";   
                                                            	   }
                                                            echo "</ul>";
                                                    	}
                                                	?>
                                            	</td>
                                            </tr>
                                        </tbody>
                                        <?php $cont+=1;}?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div> 
         <script>
         
            var ctx = document.getElementById("history").getContext('2d');
            var myChart = new Chart(ctx, {
            	    "type": "line",
            	    "data": {
            	        "labels": [<?php foreach ($arrayTime as $value) { echo '"'.$value.'"'.",";}?>],
            	        "datasets": 
                	        [{
                	            "label": "Crítica",
                	            "data": [<?php foreach ($arrayCritica as $value) { echo $value.",";}?>],
                	            "fill": false,
                	            "borderColor": "rgb(211, 47, 47)",
                	            "lineTension": 0.1
            	        	},{
                	            "label": "Alta",
                	            "data": [<?php foreach ($arrayAlta as $value) { echo $value.",";}?>],
                	            "fill": false,
                	            "borderColor": "rgb(245, 124, 0)",
                	            "lineTension": 0.1
            	        	},
            	        	{
                	            "label": "Média",
                	            "data": [<?php foreach ($arrayMedia as $value) { echo $value.",";}?>],
                	            "fill": false,
                	            "borderColor": "rgb(251, 192, 45)",
                	            "lineTension": 0.1
            	        	},
            	        	{
                	            "label": "Baixa",
                	            "data": [<?php foreach ($arrayBaixa as $value) { echo $value.",";}?>],
                	            "fill": false,
                	            "borderColor": "rgb(56, 142, 60)",
                	            "lineTension": 0.1
            	        	},
            	        	{
                	            "label": "Info",
                	            "data": [<?php foreach ($arrayInfo as $value) { echo $value.",";}?>],
                	            "fill": false,
                	            "borderColor": "rgb(30, 136, 229)",
                	            "lineTension": 0.1
            	        	}],
	        
            	    },
            	    "options": {}
            	});
        </script> 
<?php require_once('footer.php')?>
