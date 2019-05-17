<?php

namespace Omnipay\Braintree;

use Omnipay\Common\AbstractGateway;
use Braintree\Gateway as BraintreeGateway;
use Braintree\Configuration as BraintreeConfiguration;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Braintree Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * @var BraintreeGateway
     */
    protected $braintree;

    /**
     * Create a new gateway instance
     *
     * @param ClientInterface $httpClient A Guzzle client to make API calls with
     * @param HttpRequest $httpRequest A Symfony HTTP request object
     * @param BraintreeGateway $braintree The Braintree gateway
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null, BraintreeGateway $braintree = null)
    {
        $this->braintree = $braintree ?: BraintreeConfiguration::gateway();

        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest($class, array $parameters)
    {
        /** @var \Omnipay\Braintree\Message\AbstractRequest $obj */
        $obj = new $class($this->httpClient, $this->httpRequest, $this->braintree);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }

    /**
     * Get the name of the gateway
     *
     * @return string
     */
    public function getName()
    {
        return 'Braintree';
    }

    /**
     * Get an array of all default parameters for the gateway
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'publicKey' => '',
            'privateKey' => '',
            'testMode' => false,
        ];
    }

    /**
     * Get the currently configured merchant ID for the gateway
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the merchant ID for the gateway
     *
     * @param string $value
     * @return string
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the currently configured public key for the gateway
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    /**
     * Set the public key for the gateway
     *
     * @param string $value
     * @return string
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }

    /**
     * Get the currently configured private key for the gateway
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * Set the private key for the gateway
     *
     * @param string $value
     * @return string
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @param array $parameters
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\AuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CaptureRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\ClientTokenRequest
     */
    public function clientToken(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\ClientTokenRequest::class, $parameters);
    }

    /**
     * @param string $id
     * @return Message\FindCustomerRequest
     */
    public function findCustomer($id)
    {
        return $this->createRequest(\Omnipay\Braintree\Message\FindCustomerRequest::class, [
            'customerId' => $id
        ]);
    }

    /**
     * @param array $parameters
     * @return Message\CreateCustomerRequest
     */
    public function createCustomer(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CreateCustomerRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\DeleteCustomerRequest
     */
    public function deleteCustomer(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\DeleteCustomerRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdateCustomerRequest
     */
    public function updateCustomer(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\UpdateCustomerRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function find(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\FindRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\CreateMerchantAccountRequest
     */
    public function createMerchantAccount(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CreateMerchantAccountRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdateMerchantAccountRequest
     */
    public function updateMerchantAccount(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\UpdateMerchantAccountRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\CreatePaymentMethodRequest
     */
    public function createPaymentMethod(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CreatePaymentMethodRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\DeletePaymentMethodRequest
     */
    public function deletePaymentMethod(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\DeletePaymentMethodRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdatePaymentMethodRequest
     */
    public function updatePaymentMethod(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\UpdatePaymentMethodRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function releaseFromEscrow(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\ReleaseFromEscrowRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function void(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\VoidRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createSubscription(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CreateSubscriptionRequest::class, $parameters);
    }

    /**
     * @param string $subscriptionId
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function cancelSubscription($subscriptionId)
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CancelSubscriptionRequest::class, [
            'id' => $subscriptionId
        ]);
    }

    /**
     * Update a subscription with the given parameters
     *
     * @param string $subscriptionId
     * @param array $parameters
     * TODO add unit test for new method
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function updateSubscription($subscriptionId, array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\UpdateSubscriptionRequest::class, [
            'id' => $subscriptionId,
            'data' => $parameters
        ]);
    }

    /**
     * @param string $subscriptionId
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function getSubscription($subscriptionId)
    {
        // TODO implement getSubscription method
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function plans()
    {
        return $this->createRequest(\Omnipay\Braintree\Message\PlanRequest::class, []);
    }

    /**
     * @param array $parameters
     *
     * @return \Braintree\WebhookNotification
     */
    public function parseNotification(array $parameters = [])
    {
        if (isset($parameters['bt_signature']) === false || isset($parameters['bt_payload']) === false) {
            // TODO throw an exception
        }
        return \Braintree\WebhookNotification::parse(
            $parameters['bt_signature'],
            $parameters['bt_payload']
        );
    }

    /**
     * @param array $parameters
     * @return Message\FindRequest
     */
    public function fetchTransaction(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\FindRequest::class, $parameters);
    }

    /**
     * @param array $options
     * @return mixed|\Omnipay\Common\Message\AbstractRequest|RequestInterface
     */
    public function createCard(array $options = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\CreatePaymentMethodRequest::class, $options);
    }

    /**
     * @param array $options
     * @return mixed|\Omnipay\Common\Message\AbstractRequest|RequestInterface
     */
    public function updateCard(array $options = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\UpdatePaymentMethodRequest::class, $options);
    }

    /**
     * @param array $options
     * @return mixed|\Omnipay\Common\Message\AbstractRequest|RequestInterface
     */
    public function deleteCard(array $options = [])
    {
        return $this->createRequest(\Omnipay\Braintree\Message\DeletePaymentMethodRequest::class, $options);
    }
}
