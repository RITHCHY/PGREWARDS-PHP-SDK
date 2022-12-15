<?php

namespace Mds\PGRewards;

class Constants{

    public static $SANBOX_ENDPOINT = "https://devtopup.pgecom.com";

    public static $LIVE_ENDPOINT = "https://topup.pgecom.com";

    public static $HTTP_ACCEPT_HEADER = "application/json";

    public static $API_TOKEN_URI = "/api/token";

    public static $API_SEND_REWARDS_URI = "/api/balance/sendmoney";

    public static $API_CREATE_VIRTUAL_PREPAID_CARD_URI = "/api/card";

    public static $BALANCE_URI = "/api/partner/prepaid";

    public static $MINIMUM_AMOUNT = 8.0;

    public static $MAXIMUM_AMOUNT = 1000.0;

    public static $PERSON_TYPES = ['user', 'prepaid'];

}