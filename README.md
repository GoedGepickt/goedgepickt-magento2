# GoedGepickt webhooks for Magento 2
GoedGepickt webhook triggers for creating/updating orders
 
## Installation

Download the zip file to your magento 2 directory as follows:

./app/code/GoedGepickt/Webhook

and run following commands in the terminal:

```
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

## Activate Plugin
1. Log onto your Magento 2 admin account and navigate to Stores > Configuration > GoedGepickt Extensions > Integration
2. Fill out the general configuration information:
    + Active: Yes
    + Webhook Key: this key can be found as followed, in GoedGepickt navigate to Settings > Webshops > your Magento 2 shop. Here you will find a filed called Webhook key.
    
Orders will now be pushed to GoedGepickt immediately.