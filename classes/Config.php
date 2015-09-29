<?php
    
class Config 
{
    public static function get($path = null)
    {
        // If we have a path
        if($path)
        {
            // Set global config in local var
            $config = $GLOBALS['configs'];

            // Seperate each section via forward slash
            $path = explode('/', $path);

            // Foreach section of the path
            foreach($path as $bit)
            {
                // if we have it update where we are in the config
                if(isset($config[$bit]))
                {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;       
    }
}