<?php

namespace Omnipay\Braintree;

use DateTime;
use DateTimeZone;
use Omnipay\Tests\TestCase;

class MerchantIndividualTest extends TestCase
{
    /** @var MerchantIndividual */
    protected $individual;

    public function setUp()
    {
        $this->individual = new MerchantIndividual();
    }

    public function testConstructWithParams()
    {
        $individual = new MerchantIndividual(array('name' => 'Karl Childers'));
        self::assertSame('Karl Childers', $individual->getName());
    }

    public function testInitializeWithParams()
    {
        $individual = new MerchantIndividual;
        $individual->initialize(array('name' => 'Karl Childers'));
        self::assertSame('Karl Childers', $individual->getName());
    }

    public function testGetParameters()
    {
        $card = new MerchantIndividual(array(
            'name' => 'Karl Childers',
            'address1' => '522 South Main Street',
            'city' => 'Millsburg',
            'state' => 'AR',
            'postCode' => '72015',
            'birthday' => '1996-11-27',
        ));

        $parameters = $card->getParameters();
        self::assertSame('Karl', $parameters['firstName']);
        self::assertSame('Childers', $parameters['lastName']);
        self::assertSame('522 South Main Street', $parameters['address1']);
        self::assertSame('Millsburg', $parameters['city']);
        self::assertSame('AR', $parameters['state']);
        self::assertSame('72015', $parameters['postCode']);
        self::assertEquals(new DateTime('1996-11-27', new DateTimeZone('UTC')), $parameters['birthday']);
    }

    public function testFirstName()
    {
        $this->individual->setFirstName('Karl');
        self::assertEquals('Karl', $this->individual->getFirstName());
    }

    public function testLastName()
    {
        $this->individual->setLastName('Childers');
        self::assertEquals('Childers', $this->individual->getLastName());
    }

    public function testGetName()
    {
        $this->individual->setFirstName('Karl');
        $this->individual->setLastName('Childers');
        self::assertEquals('Karl Childers', $this->individual->getName());
    }

    public function testSetName()
    {
        $this->individual->setName('Karl Childers');
        self::assertEquals('Karl', $this->individual->getFirstName());
        self::assertEquals('Childers', $this->individual->getLastName());
    }

    public function testSetNameWithOneName()
    {
        $this->individual->setName('Morris');
        self::assertEquals('Morris', $this->individual->getFirstName());
        self::assertEquals('', $this->individual->getLastName());
    }

    public function testSetNameWithMultipleNames()
    {
        $this->individual->setName('Billy Bob Thornton');
        self::assertEquals('Billy', $this->individual->getFirstName());
        self::assertEquals('Bob Thornton', $this->individual->getLastName());
    }

    public function testPhone()
    {
        $this->individual->setPhone('911');
        self::assertEquals('911', $this->individual->getPhone());
    }

    public function testSsn()
    {
        $this->individual->setSsn('078.05.1120');
        self::assertEquals('078.05.1120', $this->individual->getSsn());
    }

    public function testAddress1()
    {
        $this->individual->setAddress1('522 South Main Street');
        self::assertEquals('522 South Main Street', $this->individual->getAddress1());
    }

    public function testCity()
    {
        $this->individual->setCity('Millsburg');
        self::assertEquals('Millsburg', $this->individual->getCity());
    }

    public function testPostcode()
    {
        $this->individual->setPostcode('72015');
        self::assertEquals('72015', $this->individual->getPostcode());
    }

    public function testState()
    {
        $this->individual->setState('AR');
        self::assertEquals('AR', $this->individual->getState());
    }

    public function testEmail()
    {
        $this->individual->setEmail('karl@NervousHospital.com');
        self::assertEquals('karl@NervousHospital.com', $this->individual->getEmail());
    }

    public function testBirthday()
    {
        $this->individual->setBirthday('1996-11-27');
        self::assertEquals('1996-11-27', $this->individual->getBirthday());
        self::assertEquals('1996.11.27', $this->individual->getBirthday('Y.m.d'));
    }

    public function testBirthdayEmpty()
    {
        $this->individual->setBirthday('');
        self::assertNull($this->individual->getBirthday());
    }
}
