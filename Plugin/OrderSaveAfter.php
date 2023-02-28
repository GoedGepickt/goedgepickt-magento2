<?php

namespace GoedGepickt\Webhook\Plugin;

use GoedGepickt\Webhook\Helper\Data;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class OrderSaveAfter
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var Curl
     */
    protected $_curl;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @param Data $helper
     * @param Curl $curl
     * @param LoggerInterface $logger
     */
    public function __construct(
        Data $helper,
        Curl $curl,
        LoggerInterface $logger
    ) {
        $this->_helper = $helper;
        $this->_curl   = $curl;
        $this->_logger = $logger;
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepo
     * @param $order
     * @return mixed|void
     */
    public function afterSave(\Magento\Sales\Api\OrderRepositoryInterface $orderRepo, $order)
    {
        $moduleStatus = $this->_helper->getModuleStatus();
        $webhookUrl   = $this->_helper->getWebhookUrl();
        $apiKey       = $this->_helper->getApiKey();

        if ((int)$moduleStatus !== 1) {
            return;     // Module is inactive
        } else if (empty($webhookUrl) || empty($apiKey)) {
            return;     // Incorrect module configuration
        }

        $orderData = [
            'store_id'     => $order->getStoreId(),
            'increment_id' => $order->getIncrementId(),
            'entity_id'    => $order->getEntityId(),
            'id'           => $order->getId(),
            'created_at'   => $order->getCreatedAt()
        ];

        $this->_curl->setHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => trim($apiKey)
        ]);

        $this->_curl->setOptions([
            CURLOPT_TIMEOUT => 2 // Max timeout of CURL request in seconds
        ]);

        try {
            $this->_curl->post(sprintf($webhookUrl, trim($apiKey)), json_encode($orderData));
        } catch (\Exception $e) {
            $this->_logger->debug(sprintf('Exception occurred with webhook: %s', $e->getMessage()));
        }

        return $order;
    }
}