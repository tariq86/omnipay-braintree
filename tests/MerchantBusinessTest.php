<?php

namespace Omnipay\Braintree;

use Omnipay\Tests\TestCase;

class MerchantBusinessTest extends TestCase
{
    /** @var MerchantBusiness */
    protected $business;

    public function setUp()
    {
        $this->business = new MerchantBusiness();
    }

    public function testConstructWithParams()
    {
        $business = new MerchantBusiness(array('legalName' => 'Hoochie\s Dollar Store'));
        self::assertSame('Hoochie\s Dollar Store', $business->getLegalName());
    }

    public function testInitializeWithParams()
    {
        $business = new MerchantBusiness;
        $business->initialize(array('legalName' => 'Hoochie\s Dollar Store'));
        self::assertSame('Hoochie\s Dollar Store', $business->getLegalName());
    }

    public function testGetParameters()
    {
        $card = new MerchantBusiness(array(
            'legalName' => 'Hoochie\s Dollar Store',
            'address1' => '620 W South St',
            'city' => 'Millsburg',
            'state' => 'AR',
            'postCode' => '72015',
        ));

        $parameters = $card->getParameters();
        self::assertSame('Hoochie\s Dollar Store', $parameters['legalName']);
        self::assertSame('620 W South St', $parameters['address1']);
        self::assertSame('Millsburg', $parameters['city']);
        self::assertSame('AR', $parameters['state']);
        self::assertSame('72015', $parameters['postCode']);
    }

    public function testDbaName()
    {
        $this->business->setDbaName('Hoochie\s Dollar Store');
        self::assertEquals('Hoochie\s Dollar Store', $this->business->getDbaName());
    }

    public function testLegalName()
    {
        $this->business->setLegalName('Hoochie\s Dollar Store');
        self::assertEquals('Hoochie\s Dollar Store', $this->business->getLegalName());
    }

    public function testPhone()
    {
        $this->business->setPhone('501.778.3151');
        self::assertEquals('501.778.3151', $this->business->getPhone());
    }

    public function testTaxId()
    {
        $this->business->setTaxId('98-7654321');
        self::assertEquals('98-7654321', $this->business->getTaxId());
    }

    public function testAddress1()
    {
        $this->business->setAddress1('620 W South St');
        self::assertEquals('620 W South St', $this->business->getAddress1());
    }

    public function testCity()
    {
        $this->business->setCity('Millsburg');
        self::assertEquals('Millsburg', $this->business->getCity());
    }

    public function testPostcode()
    {
        $this->business->setPostcode('72015');
        self::assertEquals('72015', $this->business->getPostcode());
    }

    public function testState()
    {
        $this->business->setState('AR');
        self::assertEquals('AR', $this->business->getState());
    }

    public function testEmail()
    {
        $this->business->setEmail('vaughn@HoochiesDollarStore.com');
        self::assertEquals('vaughn@HoochiesDollarStore.com', $this->business->getEmail());
    }
}
