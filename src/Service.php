<?php namespace Samples;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 7:50 AM
 */
use nsClient;
use nsHost;
class Service {

    const live = "https://webservices.netsuite.com";
    /**
     * @var \nsClient nsClient
     */
    private $_client;

    /**
     * create our client on construct
     * @param $email
     * @param $pass
     */
    public function __construct($email, $pass)
    {
        $this->_client = new nsClient(nsHost::live);
        $this->_client->setPassport(
            $email,
            $pass,
            $this->_account = 12345,
            $this->_role = 3
        );
    }

    /**
     * push a customer to (fake) netsuite
     * @param \stdClass $customer
     * @return int netsuite ID
     */
    public function updateCustomer(\stdClass $customer)
    {
        $nsCustomer = new \nsComplexObject('Customer');
        $nsCustomer->setFields((array) $customer);
        return $this->_client->makeCall("update", [['record' => $customer->id]]);
    }

    /**
     * pull a record from (fake) netsuite by id
     * @param $id
     * @return mixed|void
     */
    public function getCustomer($id)
    {
        return $this->_client->makeCall("get", [['record' => $id]]);
    }
}