<?php

namespace app\Libraries;

use CodeIgniter\Encryption\Encryption;
use CodeIgniter\Encryption\EncrypterInterface;
use Config\ShopSuite;
use Config\Services;


/**
 * SMS library
 *
 * Library with utilities to send texts via SMS Gateway (requires proxy implementation)
 */

class Sms_lib
{
    /**
     * SMS sending function
     * Example of use: $response = sendSMS('4477777777', 'My test message');
     */
    public function sendSMS(int $phone, string &$message): bool
    {
        $config = config(ShopSuite::class)->settings;

        $encrypter = Services::encrypter();

        $password = $config['msg_pwd'];
        if (!empty($password)) {
            $password = $encrypter->decrypt($password);
        }

        $username = $config['msg_uid'];
        $originator = $config['msg_src'];

        $response = false;

        // If any of the parameters is empty return with a false
        if (empty($username) || empty($password) || empty($phone) || empty($message) || empty($originator)) {
            return false;
        }
        
        // make sure passed string is url encoded
        $message = rawurlencode($message);

        // Add call to send a message via 3rd party API here

        return true;
    }
}
