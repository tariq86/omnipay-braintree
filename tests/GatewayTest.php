<?php

namespace Omnipay\Braintree;

use Braintree\Configuration as BraintreeConfiguration;
use Braintree\Digest as BraintreeDigest;
use Braintree\Version as BraintreeVersion;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;
    /**
     * @var array
     */
    protected $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'token' => 'abcdef',
        );
    }

    public function testFindCustomer()
    {
        $request = $this->gateway->findCustomer(1);
        static::assertInstanceOf(\Omnipay\Braintree\Message\FindCustomerRequest::class, $request);
        static::assertEquals(1, $request->getCustomerId());
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00'));
        self::assertInstanceOf(\Omnipay\Braintree\Message\AuthorizeRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testCapture()
    {
        $request = $this->gateway->capture(array('amount' => '10.00'));
        self::assertInstanceOf(\Omnipay\Braintree\Message\CaptureRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testCreateCustomer()
    {
        $request = $this->gateway->createCustomer();
        self::assertInstanceOf(\Omnipay\Braintree\Message\CreateCustomerRequest::class, $request);
    }

    public function testDeleteCustomer()
    {
        $request = $this->gateway->deleteCustomer();
        self::assertInstanceOf(\Omnipay\Braintree\Message\DeleteCustomerRequest::class, $request);
    }

    public function testUpdateCustomer()
    {
        $request = $this->gateway->updateCustomer();
        self::assertInstanceOf(\Omnipay\Braintree\Message\UpdateCustomerRequest::class, $request);
    }

    public function testCreateMerchantAccount()
    {
        $request = $this->gateway->createMerchantAccount();
        self::assertInstanceOf(\Omnipay\Braintree\Message\CreateMerchantAccountRequest::class, $request);
    }

    public function testUpdateMerchantAccount()
    {
        $request = $this->gateway->updateMerchantAccount();
        self::assertInstanceOf(\Omnipay\Braintree\Message\UpdateMerchantAccountRequest::class, $request);
    }

    public function testCreatePaymentMethod()
    {
        $request = $this->gateway->createPaymentMethod();
        self::assertInstanceOf(\Omnipay\Braintree\Message\CreatePaymentMethodRequest::class, $request);
    }

    public function testDeletePaymentMethod()
    {
        $request = $this->gateway->deletePaymentMethod();
        self::assertInstanceOf(\Omnipay\Braintree\Message\DeletePaymentMethodRequest::class, $request);
    }

    public function testUpdatePaymentMethod()
    {
        $request = $this->gateway->updatePaymentMethod();
        self::assertInstanceOf(\Omnipay\Braintree\Message\UpdatePaymentMethodRequest::class, $request);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));
        self::assertInstanceOf(\Omnipay\Braintree\Message\PurchaseRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array('amount' => '10.00'));
        self::assertInstanceOf(\Omnipay\Braintree\Message\RefundRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testReleaseFromEscrow()
    {
        $request = $this->gateway->releaseFromEscrow(array('transactionId' => 'abc123'));
        self::assertInstanceOf(\Omnipay\Braintree\Message\ReleaseFromEscrowRequest::class, $request);
        self::assertSame('abc123', $request->getTransactionId());
    }

    public function testVoid()
    {
        $request = $this->gateway->void();
        self::assertInstanceOf(\Omnipay\Braintree\Message\VoidRequest::class, $request);
    }

    public function testFind()
    {
        $request = $this->gateway->find(array());
        self::assertInstanceOf(\Omnipay\Braintree\Message\FindRequest::class, $request);
    }

    public function testClientToken()
    {
        $request = $this->gateway->clientToken(array());
        self::assertInstanceOf(\Omnipay\Braintree\Message\ClientTokenRequest::class, $request);
    }

    public function testCreateSubscription()
    {
        $request = $this->gateway->createSubscription(array());
        self::assertInstanceOf(\Omnipay\Braintree\Message\CreateSubscriptionRequest::class, $request);
    }

    public function testCancelSubscription()
    {
        $request = $this->gateway->cancelSubscription('1');
        self::assertInstanceOf(\Omnipay\Braintree\Message\CancelSubscriptionRequest::class, $request);
    }

    public function testParseNotification()
    {
        if (BraintreeVersion::MAJOR >= 3) {
            $xml = '<notification></notification>';
            $payload = base64_encode($xml);
            $signature = BraintreeDigest::hexDigestSha1(BraintreeConfiguration::privateKey(), $payload);
            $gatewayMock = $this->buildGatewayMock($payload);
            $gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest(), $gatewayMock);
            $params = array(
                'bt_signature' => $payload . '|' . $signature,
                'bt_payload' => $payload
            );
            $request = $gateway->parseNotification($params);
            self::assertInstanceOf(\Braintree\WebhookNotification::class, $request);
        } else {
            $xml = '<notification><subject></subject></notification>';
            $payload = base64_encode($xml);
            $signature = BraintreeDigest::hexDigestSha1(BraintreeConfiguration::privateKey(), $payload);
            $gatewayMock = $this->buildGatewayMock($payload);
            $gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest(), $gatewayMock);
            $params = array(
                'bt_signature' => $payload . '|' . $signature,
                'bt_payload' => $payload
            );
            $request = $gateway->parseNotification($params);
            self::assertInstanceOf(\Braintree\WebhookNotification::class, $request);
        }
    }

    /**
     * @param $payload
     *
     * @return \Braintree\Gateway
     */
    protected function buildGatewayMock($payload)
    {
        /** @var BraintreeConfiguration $configuration */
        $configuration = $this->getMockBuilder(BraintreeConfiguration::class)
            ->disableOriginalConstructor()
            ->setMethods(array(
                'assertHasAccessTokenOrKeys'
            ))
            ->getMock();
        $configuration
            ->expects($this->any())
            ->method('assertHasAccessTokenOrKeys')
            ->willReturn(null);


        $configuration->setPublicKey($payload);

        BraintreeConfiguration::$global = $configuration;
        return BraintreeConfiguration::gateway();
    }
}
