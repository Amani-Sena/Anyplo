<?php

    //Criar o arquivo .zip no caminho especificado
    $zip_file = "img/arquivos/images.zip";
    touch($zip_file);

    //Abrir .zip
    $zip = new ZipArchive();
    //$this_zip = $zip->open($zip_file);

    //Se abrir...
    if($zip->open($zip_file, ZipArchive::CREATE)) {
            $count = 0;
            foreach($pagesI as $indice_arr => $pages) { 
                    $count ++;
                    $file_with_path = $pages['paths'];
                    $name = $count . '.jpg';
                    $zip->addFile($file_with_path, $name);
            }
    $zip->close();

            if(file_exists($zip_file)) {  
                
                $download_name = "Capitulo-" . $n_cap . ".zip";
                header('Content-Type: "application/zip"');
                header("Content-Length: ".filesize($zip_file)); 
                header("Content-Disposition: attachment; filename=".$download_name);
                readfile($zip_file);

                unlink($zip_file);
                       
            }
            
    }  
?>