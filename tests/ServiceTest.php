<?php namespace SamplesTest;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 8:26 AM
 */
use Samples\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    private $customer;

    public function setUp()
    {
        $this->customer = self::mockCustomer();
    }

    public static function mockCustomer()
    {
        //build up a test object
        $customer = new \stdClass();
        $customer->name = uniqid('John Test');
        $customer->email = uniqid('test').'@test.com';
        $customer->address = rand(1,5000).' test street';
        $cities = ['Roswell', 'Austin', 'Memphis', 'San Jose'];
        $customer->city = $cities[array_rand($cities)];
        $states = ['NC', 'TX', 'VA', 'CT'];
        $customer->state = $states[array_rand($states)];
        $customer->zip = rand(10000,70000);

        return $customer;
    }

    public function testUpdateCustomer()
    {
        return ;
        $service = new Service($sandboxKey = 1212312, $sandboxPassword = 55555);

        $id = $service->updateCustomer($this->customer);
        $this->assertGreaterThan(0, $id);

        $savedCustomer = json_decode($service->getCustomer($id));
        $this->assertEquals($this->customer, $savedCustomer);
    }
}