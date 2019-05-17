<?php

namespace Omnipay\Braintree\Message;

/**
 * Update Subscription Request
 *
 * @method CustomerResponse send()
 */
class UpdateSubscriptionRequest extends AbstractRequest
{
    /** @var string */
    protected $subscriptionId;

    public function getData()
    {
        return $this->getSubscriptionData();
    }

    public function getSubscriptionData()
    {
        return $this->getParameter('subscriptionData');
    }

    /**
     * Send the request with specified data
     * @param mixed $data The data to be updated
     * @return SubscriptionResponse
     */
    public function sendData($data)
    {
        $response = $this->braintree->subscription()->update($data['subscriptionId'], $data);

        return $this->response = new SubscriptionResponse($this, $response);
    }

    public function setId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }
}