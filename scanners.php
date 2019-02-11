<?php require_once('header.php');?>
<?php $scanners = ScannerDAO::listScanners();?>
        <!-- PAGE CONTAINER-->
        <div class="page-container">
        
            <!-- HEADER DESKTOP ------ >search Item  --> 
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
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Scanners</h2>
                                    <button class="au-btn au-btn-icon au-btn--blue" data-toggle="collapse" data-target="#add-scanner">
                                        <i class="fas fa-plus"></i>Add Scanner</button>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25 collapse " id="add-scanner">
	                            <div class="col-12 card">
	                            	<div class="card-body">
		                            	<form class="form" action="scannersController.php?action=insert" method="post"  id="addScannerForm" >
								            <div class="row">
									            <div class="form-group col-md-9 col-lg-6 col-sm-12">
									                <label  for="hostname">Hostname ou IP:</label>
									                <input class="form-control" type="text" name="hostname"id="hostname" placeholder="IP">
									                
									            </div>
								            
									            <div class="form-group col-md-6 col-lg-3 col-sm-12">
									                <label for="port">Port</label>
									                <input class="form-control" type="text" name="port" id="port" placeholder="Port">
									            </div>
									            
								            </div>
								            <div class="row">
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="Username">Username</label>
									                <input class="form-control " type="text" name="username" id="username" placeholder="Username">
									            </div>
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="password">Password</label>
									                <input  class="form-control mb-0" type="password" name="password" id="password" placeholder="Password">
									            </div>
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="nome">Nome Scanner</label>
									                <input  class="form-control mb-0" type="text" name="nome" id="nome" placeholder="Nome Scanner">
									            </div>
								            </div>
								            <div class="row">
    								            <div class="form-group col-md-1 col-lg-1 col-sm-12">
   									            	<button class="form-control btn btn-info " onClick="submitForm(document.addScannerForm,document.addScannerForm.hostname)" >
    									            	Add  <i class="icon fas fa-check"></i>
    									            </button>
									            </div>
								            </div>
							            </form>
	                            	</div>
	                            </div>
                            </div>
                        <?php $count=0; 
							foreach ($scanners as $scanner) {?>
	                        <div class="row m-t-25">
	                            <div class="col-12">
	                                <div class="overview-item overview-item--c2 ">
	                                    <div class="overview__inner"  >
	                                        <div class="overview-box">
	                                            <div class="icon">
	                                                <i class="fas fa-terminal" ></i>
	                                            </div>
	                                            <div class="text text-muted ">
	                                                <h2 class="mt-2"><?=$scanner->getHost()?>:<?=$scanner->getPort()?></h2>
	                                            </div>
	                                            <div class="float-right">
	                                            	<button class="icon align-middle " data-toggle="collapse" data-target="#scanner-details<?=$count?>">
	                                            		<i class="fas fa-edit">
	                                            		</i>
	                                            	</button>
	                                            	<form class="float-right" action="scannersController.php?action=delete" method="post"  id="deleteForm<?=$scanner->getId()?>" >
    	                                            	<button class="icon ml-3 mt-1 align-middle" form="deleteForm<?=$scanner->getId()?>" type="submit" value="Submit">
    	                                            		<i class="fas fa-times"></i>
    	                                            	</button>
    	                                            	<input name="scanner-id" hidden="true" id="scanner-id" value="<?=$scanner->getId()?>">
	                                            	</form>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row m-t-25 collapse " id="scanner-details<?=$count?>">
	                            <div class="col-12 card">
	                            	<div class="card-body">
		                            	<form class="form" action="scannersController.php?action=update" method="post"  id="updateForm<?=$scanner->getId()?>" >
								            <!-- TEXT FIELD GROUPS -->
								            <div class="row">
									            <div class="form-group col-md-9 col-lg-6 col-sm-12">
									                <label  for="hostname">Hostname/IP:</label>
									                <input class="form-control" type="text" name="hostname" placeholder="<?=$scanner->getHost()?>">
									                <input name="scanner-id" hidden="true" id="scanner-id" value="<?=$scanner->getId()?>">
									            </div>
								            
									            <div class="form-group col-md-6 col-lg-3 col-sm-12">
									                <label for="port">Port</label>
									                <input class="form-control" type="text" name="port" placeholder="<?=$scanner->getPort()?>">
									            </div>
									            
								            </div>
								            <div class="row">
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="Username">Username</label>
									                <input class="form-control " type="text" name="username" placeholder="<?=$scanner->getUsername()?>">
									            </div>
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="password">Password</label>
									                <input  class="form-control mb-0" type="password" name="password" placeholder="Password">
									            </div>
									            <div class="form-group col-md-4 col-lg-3 col-sm-12">
									                <label for="nome">Nome Scanner</label>
									                <input  class="form-control mb-0" type="text" name="nome" id="nome" placeholder="<?=$scanner->getNome()?>">
									            </div>
								            </div>
								            
								            <div class="row">
    								            <div class="form-group col-md-2 col-lg-2 col-sm-12">
    									            <button class="form-control btn btn-success" form="updateForm<?=$scanner->getId()?>" type="submit" value="Submit" >
    									            	Confirmar! <i class="icon fas fa-check"></i>
    									            </button>
									            </div>
								            </div>
							            </form>
	                            	</div>
	                            </div>
                            </div>
                        <?php $count++;}?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>
        
<?php require_once('footer.php');?>
