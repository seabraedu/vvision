<?php
require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php'); 
class Integration {
    
    /*---------------Inicio integração de sessão---------------*/
    //Cria uma sessão com o nessus em caso de sucesso retorna  o token
    public static function createSession ($scanner){
        $data = json_encode(array("username"=>$scanner->getUsername(),"password"=>$scanner->getPassword()));
        return Integration::sendCurlPOST("",$scanner, "/session", $data);
    }
    //Retorna detalhes da sessão criada com o nessus 
    public static function getSession ($token,$scanner){
        return Integration::sendCurlGET($token,$scanner, "/session");
    }
    /*---------------Termino integração de sessão---------------*/
    
    /*---------------Inicio integração de Folders---------------*/
    //Lista todas as pastas do Nessus Scanner
    public static function listFolders ($token,$scanner):array{
        return Integration::sendCurlGET($token, $scanner,"/folders");
    }
    //Cria uma pasta no Nessus scanner
    public static function createFolder ($name,$scanner,$token):array{
        $data = json_encode(array("name"=>$name));
        Integration::sendCurlPOST($token, $scanner, '/folders', $data);
    }
    //Retorna uma lista de scans a partir de uma pasta 
    public static function scanListFromFolder($token,$scanner,$folder) {
        return Integration::sendCurlGET($token, $scanner, "/scans?folder_id=".$folder->getId());   
    }
    /*---------------Termino integração de Folders---------------*/
    
    /*---------------Inicio  integração  de Scans ---------------*/
    public static function getScanHistory($token,$scanner,Scan $scan) {
        $array_scan_detail = Integration::sendCurlGET($token, $scanner, "/scans/".$scan->getId());
        $return_array_history = array();
        foreach ($array_scan_detail['history'] as $history) {
            $scan_history = new Scan();
            $scan_history->setId($history['history_id']);
            $scan_history->setCreation_date($history['creation_date']);
            $scan_history->setLast_modification_date($history['last_modification_date']);
            $scan_history->setFolder_id($scan->getFolder_id());
            $scan_history->setOwner($scan->getOwner());
            $scan_history->setName($scan->getName());
            $scan_history->setStatus($scan->getStatus());
            $scan_history->setHistory_of($scan->getId());
            array_push($return_array_history, $scan_history);
        }
        return $return_array_history;
    }
    /*---------------Termino  integração  de Scans ---------------*/
    
    /*---------------Inicio  integração  de Hosts ---------------*/
    public static function getScanHosts($token,$scanner,Scan $scan) {
        $history=$scan->getHistory_of();
        if (!isset($history))
            $path = "/scans/".$scan->getId();
        else 
            $path = "/scans/".$scan->getHistory_of()."?history_id=".$scan->getId();
        $host_array = Integration::sendCurlGET($token, $scanner, $path);
        $returnHostarray = array();
        //var_dump($array_scan_detail['history']);
        if ( count($host_array)){
            foreach ($host_array['hosts'] as $nHost) {
                $host = new Host();
                $host->setHostname($nHost['hostname']);
                $host->setId($nHost['host_id']);
                $host->setScan_id($scan->getId());
                $host->setSeverity($nHost['severity']);
                $host->setCritical($nHost['critical']);
                $host->setHigh($nHost['high']);
                $host->setMedium($nHost['medium']);
                $host->setLow($nHost['low']);
                $host->setInfo($nHost['info']);
                array_push($returnHostarray, $host);
            }
            return $returnHostarray;
        }
    }
    /*---------------Termino  integração  de Hosts ---------------*/
    
    /*---------------Inicio  integração  de Vulnerability ---------------*/
    public static function getScanVulnerabitiesFromHost ($token,$scanner,Scan $scan,Host $host) {
        $history=$scan->getHistory_of();
        if (!isset($history))
            $path = "/scans/".$scan->getId()."/hosts/".$host->getId();
        else
            $path = "/scans/".$scan->getHistory_of()."/hosts/".$host->getId()."?history_id=".$scan->getId();
            $vuln_array = Integration::sendCurlGET($token, $scanner, $path);
            $returnVulnHostarray = array();
            //var_dump($array_scan_detail['history']);
            if ( count($vuln_array)>0){
                foreach ($vuln_array['vulnerabilities'] as $nVuln) {
                    $vuln = new Vulnerability();
                    $vuln->setPlugin_id($nVuln['plugin_id']);
                    $vuln->setName($nVuln['plugin_name']);
                    $vuln->setSeverity($nVuln['severity']);
                    $vuln->setHost_id($nVuln['host_id']);
                    $vuln->setScan_id($scan->getId());
                    $vuln->setId($nVuln['vuln_index']);
                    array_push($returnVulnHostarray, $vuln);
                }
                return $returnVulnHostarray;
            }
    }
    /*---------------Inicio  integração  de Plugin Output ---------------*/
    //Este metodo deverá ser chamado apenas sob demanda e não será realizado dump...
    //O retorno deste método será um json para ser enviado ao JS para formatação.
    public static function getScanVulnerabitiesPluginOutput ($token,$scanner,Scan $scan,Host $host,Vulnerability $vuln) {
        $history=$scan->getHistory_of();
        if (!isset($history))
            $path = "/scans/".$scan->getId()."/hosts/".$host->getId()."/plugins/".$vuln->getPlugin_id();
        else
            $path = "/scans/".$scan->getHistory_of()."/hosts/".$host->getId()."/plugins/".$vuln->getPlugin_id()."?history_id=".$scan->getId();
            $vuln_array = Integration::sendCurlGET($token, $scanner, $path);
            //var_dump($array_scan_detail['history']);
            if ( count($vuln_array)>0){
                $returnVulnHostarray = $vuln_array;
                return $returnVulnHostarray;
            }
    }
    
    
    
    
    
    
    
    /* ------------------ Metodos de comunicação com o Scanner Nessus ------------------ */ 
    //envia comandos GET para o scanner Nessus
    private static function sendCurlGET($token,$scanner,$path) {
        //URL
        $ch = curl_init("https://".$scanner->getHost().":".$scanner->getPort()."$path");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Disable SSL verification
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
        //Debug Options
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        //Connection Control
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // times out after 8s
        //RESQUEST HEADERS - for Json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Accept: application/json, text/javascript, */*;',
            'Accept-Encoding: *;',
            "X-Cookie: token=".$token));
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result){
            return json_decode($result,true);
        }
    }
    //envia comandos POST para o scanner Nessus
    private static function sendCurlPOST($token,$scanner,$path,$data) {
        $ch = curl_init("https://".$scanner->getHost().":".$scanner->getPort().$path);
        //POST request +JsonData +Response
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Disable SSL verification
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
        //Debug Options
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        //Connection Control
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// permite o direcionamento
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // configurando timeout para o resquest - 2s
        //RESQUEST HEADERS - for Json - com Token e sem Token(para o caso de uma nova sessão)
        if (!$token===""){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Accept: application/json, text/javascript, */*;',
            'Accept-Encoding: *;',
            "X-Cookie: token=".$token));
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                'Accept: application/json, text/javascript, */*;',
                'Accept-Encoding: *;'));
        }
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result){
            return json_decode($result,true);
        }
    }
}



?>