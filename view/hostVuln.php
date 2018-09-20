<?php

require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');
$hostname = "161.148.24.39";
$array =VulnerabilityDAO::getVulnerabiliiesFromHost("$hostname");


?>
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8">
     <title>ECharts</title>
     <!-- including ECharts file -->
     <script src="./echarts.min.js"></script>
 </head>
 <body>
     <!-- prepare a DOM container with width and height -->
     <div id="main" style="width: 50%;height:360px;"></div>
     
     <script type="text/javascript">
         // based on prepared DOM, initialize echarts instance
         var myChart = echarts.init(document.getElementById('main'));
         
         // specify chart configuration item and data
         var option = {
        	 color: ['#c62828', '#ef6c00', '#c8b900', '#00701a','#0277bd'],
             tooltip : {
                 trigger: 'axis',
                 axisPointer : {            
                     type : 'shadow'       
                 }
             },
             title: {
                 text: '<?=$hostname?>',
                 subtext: 'Histórico de vulnerabilidades do host: <?=$hostname?>'
             },
             legend: {
                 data: ['critical', 'high','medium','low','info']
             },
             grid: {
                 left: '3%',
                 right: '4%',
                 bottom: '3%',
                 containLabel: true
             },
             xAxis:  {
            	 type: 'category',
                 data: [<?=$array["modification"]?>],
                 namegap:30
                 
                	 
             },
             yAxis: {
                 
            	 type: 'value',
             },
             series: [
            	 
                 {
                	 
                     name: 'critical',
                     type: 'bar',
                     stack: 'vulnerability',
                     label: {
                         normal: {
                             show: true,
                             position: 'insideRight',
                             onZero: false
                         }
                     },
                     data: [<?=$array['critical']?>]
                 },
                 {
                     name: 'high',
                     type: 'bar',
                     stack: 'vulnerability',
                     label: {
                         normal: {
                             show: true,
                             position: 'insideRight'
                         }
                     },
                     data: [<?=$array['high']?>]
                 },
                 {
                     name: 'medium',
                     type: 'bar',
                     stack: 'vulnerability',
                     label: {
                         normal: {
                             show: true,
                             position: 'insideRight'
                         }
                     },
                     data: [<?=$array['medium']?>]
                 },
                 {
                     name: 'low',
                     type: 'bar',
                     stack: 'vulnerability',
                     label: {
                         normal: {
                             show: true,
                             position: 'insideRight'
                         }
                     },
                     data: [<?=$array['low']?>]
                 },
                 {
                     name: 'info',
                     type: 'bar',
                     stack: 'vulnerability',
                     label: {
                         normal: {
                             show: true,
                             position: 'insideRight'
                         }
                     },
                     data: [<?=$array['info']?>]
                 }
             ]
         };

         // use configuration item and data specified to show chart
         myChart.setOption(option);
         
     </script>
 </body>
 </html>
