<?php
    
class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user)
        {
            if(Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);
                
                if($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
                else
                {
                    // Logout
                }
            }
        }
        else
        {
            $this->find($user);
        }
    }

    public function create($fields)
    {
        if(!$this->_db->insert('users', $fields))
        {
            throw new Exception('Error creating account');
        }
    }

    public function find($user = null)
    {
        if($user)
        {
            $field = (is_numeric($user)) ? 'Id' : 'Username';

            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count())
            {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null, $remember = false)
    {

        if(!$username && !$password && $this->exists())
        {
            Session::put($this->_sessionName, $this->data()->Id);
        }
        else
        {
            $user = $this->find($username);

            if($user)
            {
                if($this->data()->Password === Hash::make($password, $this->data()->Salt))
                {
                    Session::put($this->_sessionName, $this->data()->Id);

                    if($remember)
                    {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if(!$hashCheck->count())
                        {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->Id,
                                'hash' => $hash));
                        }
                        else
                        {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function logout()
    {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->Id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function exists()
    {
        return (!empty($this->_data) ? true : false);
    }

    public function update($fields = array(), $id = null)
    {
        if(!$id && $this->isLoggedIn())
        {
            $id = $this->data()->Id;
        }

        if(!$this->_db->update('users', $fields, 'Id = ' . $id))
        {
            throw new Exception('Error updating.');
        }
    }
}

