<?php

namespace GoedGepickt\Webhook\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Data
{

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
    }

    public function getModuleStatus()
    {
        return $this->_scopeConfig->getValue('sales_order_webhook_integration_options/webhook_settings/active');
    }

    public function getWebhookUrl()
    {
        return 'https://account.goedgepickt.nl/webhook/magento2/handle-order-webhook';
    }

    public function getApiKey()
    {
        return $this->_scopeConfig->getValue('sales_order_webhook_integration_options/webhook_settings/connection_key');
    }
}
