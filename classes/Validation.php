<?php
    
class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;
           
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach($items as $item => $rules)
        {
            $name = ($rules['name']);

            foreach($rules as $rule => $rule_value)
            {

                $value = trim($source[$item]);                          
                
                if($rule == 'required' && empty($value))
                {
                    $this->addError("{$name} is required");
                }
                else if(!empty($value))
                {
                    switch($rule)
                    {
                        case 'min':
                            if(strlen($value) < $rule_value)
                            {
                                $this->addError("{$name} must be a minimum of {$rule_value} characters in length");
                            }
                        break;

                        case 'max':
                            if(strlen($value) > $rule_value)
                            {
                                $this->addError("{$name} must be a maximum of {$rule_value} characters in length");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value])
                            {
                                $this->addError("{$name}s do not match");
                            }
                        break;
                        case 'unique':

                        $check = $this->_db->get($rule_value, array($item, '=', $value));

                        if($check->count())
                        {
                            $this->addError("{$name} is already taken");
                        }

                    }
                }
            }
        }

        if(empty($this->_errors))
        {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
