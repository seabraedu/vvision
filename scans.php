<?php require_once('header.php');?>
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
                                    <h2 class="title-1">Scans</h2>
                                    <a href="scanController.php?action=sync_scans">Sync <i class="fas fa-sync"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php $scansArray = ScanDAO::listScansHostsMonitored();?>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th class="text-center col-1" >ID</th>
                                                <th class="text-center">Nome</th>
                                                <th class="text-center ">Crítica</th>
                                                <th class="text-center col-1" >Alta</th>
                                                <th class="text-center col-1 ">Média</th>
                                                <th class="text-center col-1 ">Baixa</th>
                                                <th class="text-center col-1 ">Info</th>
                                                <th class="text-center col-2 px-0 ">modificado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scansArray as $scan) {?>
                                                <tr onclick="window.location='scanController.php?action=detail&scan_id=<?=$scan['id']?>&scanner_id=<?=$scan['scanner_id']?>&scan_name=<?=$scan['name']?>'">
                                                    <td class="text-center col-1"><?=$scan['id']?></td>
                                                    <td class="text-center "><?=$scan['name']?></td>
                                                    <td class="text-center text-light col-1 bg-danger "><?=$scan['critical']?></td>
                                                    <td class="text-center col-1 text-light" style="background: orange"><?=$scan['high']?></td>
                                                    <td class="text-center text-light col-1 bg-warning" ><?=$scan['medium']?></td>
                                                    <td class="text-center text-light col-1 bg-success "><?=$scan['low']?></td>
                                                    <td class="text-center text-light col-1 bg-info"><?=$scan['info']?></td>
                                                    <td class="text-center  col-2 px-0"><?=$scan['last_modification_date']?></td>
                                                    
                                          
                                                </tr> 
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>   
         <script>
         jQuery(document).ready(function($) {
        	    $(".clickable-row").click(function() {
					alert($(this).data("href"));
        	        window.location = $(this).data("href");
        	        
        	    });
        	});
         </script>
<?php require_once('footer.php')?>
