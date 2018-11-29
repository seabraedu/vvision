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
                                    <h2 class="title-1">Folders</h2>
                                </div>
                            </div>
                        </div>
                        <?php $foldersArray = FolderDAO::listAllFoldersInDB();?>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Nome</th>
                                                <th class="text-center">Scanner Id</th>
                                                <th class="text-center">Scanner hostname/IP</th>
                                                <th class="text-right" >Total Não lidos</th>
                                                <th class="text-left p-0">Monitorar</th>
                                                <th class="text-right p-0">
                                                	<div class="icon mr-4">
	                                            		<a class="text-light" href="folderController.php?action=sync"><i class="fas fa-sync"> </i></a> 
	                                            	</div>
                                            	</th>
                                            </tr>
                                        </thead>
                                        <?php foreach ($foldersArray as $folder) {?>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><?=$folder->getId()?></td>
                                                <td class="text-center"><?=$folder->getName()?></td>
                                                <td class="text-center"><?=$folder->getScanner_id()?></td>
                                                <td class="text-center"><?php $scanner = ScannerDAO::loadScannerById($folder->getScanner_id());
                                                      echo  $scanner->getHost();?></td>
                                                <td class="text-right"><?=$folder->getUnread_count()?></td>
                                                <td class="text-right" colspan="2"> 
	                                                <form id="monitorarFolder<?=$folder->getScanner_id()?>,<?=$folder->getId()?>" action="folderController.php?action=update" method="post" >
                                                    	<input  type="checkbox" name="monitorStatus" id="monitorStatus" value="<?=FolderDAO::monitoredGetState($folder->getId(), $folder->getScanner_id())?>" <?php if (FolderDAO::monitoredGetState($folder->getId(), $folder->getScanner_id()) ==='yes') echo "checked";?>> 
                                                    	<input id='id' type='hidden' value='<?=$folder->getId()?>' name='id'>
                                                    	<input id='scanner_id' type='hidden' value='<?=$folder->getScanner_id()?>' name='scanner_id'>
                                                    	<button class="btn btn-info ml-5"  type="submit" form="monitorarFolder<?=$folder->getScanner_id()?>,<?=$folder->getId()?>" > Salvar !</button>
                                                    	
                                                    </form>
                                              	</td>                                            
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
