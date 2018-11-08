<?php require_once('header.php');
//Listando todas as folders de um scanner
$scanner = ScannerDAO::listScanners();

//$token = new Token();
//var_dump(Integration::listFolders($token->getToken($scanner), $scanner));
//var_dump(FolderDAO::refreshFolderFromScanner($token->getToken($scanner),$scanner));
?>
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
                                    <h2 class="title-1">Folders</h2>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>
<?php require_once('footer.php');?>
<script>
function submitForm(form,hostname){
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
 if(hostname.value.match(ipformat)){
	//form.submit;
 	alert("entrei");
 }
 else{
 	alert("You have entered an invalid IP address!");
 	document.form1.text1.focus();return false;
 	}
}
</script>