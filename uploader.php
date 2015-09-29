<?php

if(isset($_FILES['file']))
{
    $file = $_FILES['file'];

    // File Properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // File Extension
    $file_explode = explode('.', $file_name);
    $file_ext = strtolower(end($file_explode));

    $file_prefix = strtolower($file_explode[0]);

    $allowedFiles = array('jpg', 'jpeg', 'png');

    if(in_array($file_ext, $allowedFiles))
    {
        if($file_error === 0)
        {
            if($file_size <=  4194304)
            {
                $file_name_new = uniqid($file_prefix, true) . '.' . $file_ext;
                $file_destination = 'uploads/' . $file_name_new;

                if(move_uploaded_file($file_tmp, $file_destination))
                {
                    echo $file_destination;
                }
                else
                {
                    // FAILED TO UPLOAD
                }
            }
            else
            {
                // FILE TO BIG
            }
        }
        else
        {
            // ERROR FOUND IN FILE
        }
    }
}

?>