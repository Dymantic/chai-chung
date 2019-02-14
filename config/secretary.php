<?php

return [
    /*
     *  What address should the mail be sent to.
     *  The from address is made from the the address of the sender and their name
     */
    'sends_email_to'        => '',

    /*
     * The url for you Slack incoming webhook
     */
    'slack_endpoint'        => '',

    /*
     * Where on your Slack would you like the message to appear?
     * You may use a slack #channel or @username
     */
    'slack_recipient'       => '#general',

    /*
     * What channels should the notification be sent through.
     * This is the same as Laravel's notification channels.
     * Currently supported are 'mail' and 'slack'
     */
    'notification_channels' => ['mail']
];