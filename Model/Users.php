<?php

namespace Model;

class Users
{
    protected $id;
    protected $name;
    protected $mail;
    protected $password;

    public function getProperties()
    {
      return get_object_vars($this);
    }

    public function getTableNameBdd()
    {
      return 'users';
    }

    public function setId($id)
    {
      return $this->id = $id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function setName($name)
    {
      return $this->name = $name;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setMail($mail)
    {
      return $this->mail = $mail;
    }

    public function getMail()
    {
      return $this->mail;
    }

    public function setPassword($password)
    {
      return $this->password = $password;
    }

    public function getPassword()
    {
      return $this->password;
    }

}
