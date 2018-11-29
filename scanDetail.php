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
                                    <h2 class="title-1">Scan Detail</h2>
                                </div>
                            </div>
                        </div>
                        <?php $vulnsArray = VulnerabilityDAO::getAllVulnerabilitiesFromScan((int)$_GET['scan_id']);?>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                
                                                <th class="text-left">Nome</th>
                                                <th class="text-right col-1 ">Severity</th>

                                            </tr>
                                        </thead>
                                        <?php foreach ($vulnsArray as $scan) {?>
                                        <tbody>
                                            <tr>
                                                <td class="text-left "><?=$scan['name']?></td>
                                                <td class="text-right col-1  "><?=$scan['severity']?></td>                                            
                                            </tr> 
                                        </tbody>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>   
<?php require_once('footer.php')?>
