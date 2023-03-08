<?php

namespace App\Employee;

class Employee
{
    protected $name ;
    protected $age ;
    protected $salary;

    public function __construct(string $name,float $salary,int $age)
    {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSalery() :float
    {
        return $this->salary;
    }
    
    public function __toString()
    {
        return 'name : '.$this->name.'<br>age : '.$this->age.'<br>salary : '.$this->salary;
    }
}

namespace App\Manager;

use App\Employee\Employee;

class EmployeeManager extends Employee
{
    public function getSalery():float
    {
        return $this->salary * 2;
    }
    public function welcome(){
        return 'welcome';
    }
}

class Manager{

    protected Employee $emp ;
    protected EmployeeManager $empManager ;

    public  function __construct()
    {
        $this->emp = new EmployeeManager('sayed',4000,40);
        $this->empManager = new EmployeeManager('sayed',3000,40);
    }

    public function main()
    {
        return $this->emp->welcome();
    }

}

$manager = new Manager();
echo $manager->main();