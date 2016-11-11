<?php


namespace AppBundle\Services;


class ArchiveManager {
    public function log($logger) {
        $archivepathname="C:/Users/User-PC/Desktop/VerwaltungVGBS/logs/".date('Y');
        if(!is_dir($archivepathname)){
            mkdir($archivepathname);
        }
        $xml=  simplexml_load_file($archivepathname.'/'.date('Y-m').'.xml') or die("Error: Cannot create object");
       
     
        $xml->addChild("date",date("d.m.Y - H:i", time()));
        foreach ($logger->queries as $logitem){
                    $log=$xml->addChild('log');
                    $log->addChild('query', $logitem['sql']);
                    
                    
                    
//                    if($logitem['params'] != NULL){
//                    fwrite($myfile, "<parameters>\n");
//                    
//                    foreach ($logitem['params'] as $key=>$param){
//                        if(gettype($param)== 'object'){
//                            $param=$param->format('Y-m-d');
//                        }
//                        fwrite($myfile, '<param type='.$logitem['types'][$key].'>'.$param."</param>");
//                    }
//                    
//                    
//                    fwrite($myfile, "</parameters>\n");
//                    }
                    
                    
//                    fwrite($myfile, "</query>\n");
                    
                }
        $xml->saveXML($archivepathname.'/'.date('Y-m').'.xml');
                
//        $myfile = fopen($archivepathname."/".date('Y-m').".xml", "a") or die("Unable to open file!");
//        fwrite($myfile, "\n");
//        fwrite($myfile, "\n");
//        fwrite($myfile, "<transaction>\n");
//        fwrite($myfile, "<execution_time>".date("d.m.Y - H:i", time())."</execution_time>\n");
//                foreach ($logger->queries as $logitem){
//                    fwrite($myfile, "<query>\n");
//                    
//                    fwrite($myfile, "<querystring>".$logitem['sql']."</querystring>\n");
//                    
//                    if($logitem['params'] != NULL){
//                    fwrite($myfile, "<parameters>\n");
//                    
//                    foreach ($logitem['params'] as $key=>$param){
//                        if(gettype($param)== 'object'){
//                            $param=$param->format('Y-m-d');
//                        }
//                        fwrite($myfile, '<param type='.$logitem['types'][$key].'>'.$param."</param>");
//                    }
//                    
//                    
//                    fwrite($myfile, "</parameters>\n");
//                    }
//                    
//                    
//                    fwrite($myfile, "</query>\n");
//                    
//                }
//                fwrite($myfile, "</transaction>\n");
//                
//                fclose($myfile);
//        
//    }
}
}