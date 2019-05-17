<?php

namespace Omnipay\Braintree;

use \Braintree\MerchantAccount;
use Omnipay\Tests\TestCase;

class MerchantFundingTest extends TestCase
{
    /** @var MerchantFunding */
    protected $funding;

    public function setUp()
    {
        $this->funding = new MerchantFunding();
    }

    public function testConstructWithParams()
    {
        $funding = new MerchantFunding(array('descriptor' => 'Millsburg National Bank'));
        self::assertSame('Millsburg National Bank', $funding->getDescriptor());
    }

    public function testInitializeWithParams()
    {
        $funding = new MerchantFunding;
        $funding->initialize(array('descriptor' => 'Millsburg National Bank'));
        self::assertSame('Millsburg National Bank', $funding->getDescriptor());
    }

    public function testGetParameters()
    {
        $card = new MerchantFunding(array(
            'descriptor' => 'Millsburg National Bank',
            'destination' => MerchantAccount::FUNDING_DESTINATION_BANK,
            'email' => 'payment@hoochiesdollarstore.com',
            'mobilePhone' => '501.778.3151',
            'accountNumber' => '1123581321',
            'routingNumber' => '071101307'
        ));

        $parameters = $card->getParameters();
        self::assertSame('Millsburg National Bank', $parameters['descriptor']);
        self::assertSame(MerchantAccount::FUNDING_DESTINATION_BANK, $parameters['destination']);
        self::assertSame('payment@hoochiesdollarstore.com', $parameters['email']);
        self::assertSame('501.778.3151', $parameters['mobilePhone']);
        self::assertSame('1123581321', $parameters['accountNumber']);
        self::assertSame('071101307', $parameters['routingNumber']);
    }

    public function testAccountNumber()
    {
        $this->funding->setAccountNumber('1123581321');
        self::assertEquals('1123581321', $this->funding->getAccountNumber());
    }

    public function testRoutingNumber()
    {
        $this->funding->setRoutingNumber('071101307');
        self::assertEquals('071101307', $this->funding->getRoutingNumber());
    }

    public function testMobilePhone()
    {
        $this->funding->setMobilePhone('501.778.3151');
        self::assertEquals('501.778.3151', $this->funding->getMobilePhone());
    }

    public function testDescriptor()
    {
        $this->funding->setDescriptor('Millsburg National Bank');
        self::assertEquals('Millsburg National Bank', $this->funding->getDescriptor());
    }

    public function testDestination()
    {
        $this->funding->setDestination(MerchantAccount::FUNDING_DESTINATION_BANK);
        self::assertEquals(MerchantAccount::FUNDING_DESTINATION_BANK, $this->funding->getDestination());
    }

    public function testEmail()
    {
        $this->funding->setEmail('payment@hoochiesdollarstore.com');
        self::assertEquals('payment@hoochiesdollarstore.com', $this->funding->getEmail());
    }
}
