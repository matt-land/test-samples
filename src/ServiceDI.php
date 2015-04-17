<?php namespace Samples;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 7:50 AM
 */

class ServiceDI {

    const live = "https://webservices.netsuite.com";
    /**
     * @var nsClient nsClient
     */
    private $_client;

    public function __construct($nsClient, $email, $pass)
    {
        $this->_client = $nsClient;
        $this->_client->setPassport(
            $email,
            $pass,
            $this->_account = 12345,
            $this->_role = 3
        );
    }

    public function updateCustomer(stdClass $customer)
    {
        $nsCustomer = new nsComplexObject('Customer');
        $nsCustomer->setFields((array) $customer);
        return $this->_client->makeCall("update", [['record' => $customer->id]]);
    }
}