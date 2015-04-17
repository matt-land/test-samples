<?php
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 8:26 AM
 */
use Samples\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateCustomer()
    {
        $service = new Service($email = 'apiuser', $pass = uniqid('password'));

        //build up a test object
        $customer = new stdClass();
        $customer->name = uniqid('John Test');
        $customer->email = uniqid('test').'@test.com';
        $customer->address = rand(1,5000).' test street';
        $cities = ['Roswell', 'Austin', 'Memphis', 'San Jose'];
        $customer->city = $cities[array_rand($cities)];
        $states = ['NC', 'TX', 'VA', 'CT'];
        $customer->state = $states[array_rand($states)];
        $customer->zip = rand(10000,70000);

        //$service->updateCustomer($customer);

        //$service->getC
    }
}