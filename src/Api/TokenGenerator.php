<?php

namespace Theme2022\Api;

/**
 * Used to generate token expire or not
 * Class TokenGenerator
 *
 * @package Theme2022\Api
 */
class TokenGenerator {
    private $key;
    private $method = 'aes128';

    public function __construct(string $secretString) {
        $this->key = sha1(md5($secretString));
    }

    private function base64url_encode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private function base64url_decode($data) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    public function getDataFromToken($token) {
        $token = $this->base64url_decode($token);
        $iv_size = openssl_cipher_iv_length($this->method);
        $iv = substr($token, 0, $iv_size);

        return json_decode(openssl_decrypt(substr($token, $iv_size), $this->method, $this->key, 0, $iv), true);
    }

    /**
     * @param $token
     *
     * @return bool
     */
    public function isExpireToken($token) {
        $data = $this->getDataFromToken($token);
        $currentDate = new \DateTime();
        $dateExpire = \DateTime::createFromFormat(\DateTime::ISO8601, $data['expire']);
        return $currentDate > $dateExpire;
    }

    /**
     * Expire time is a string of DateInterval
     *
     * @param array $data
     * @param false $canExpire
     * @param string $expireTime
     *
     * @return string|string[]
     * @throws \Exception
     */
    public function generate(array $data, bool $canExpire = false, string $expireTime = 'P5M') {
        if ($canExpire) {
            $dateExpire = new \DateTime();
            $dateExpire->add(new \DateInterval($expireTime));
            $data['expire'] = $dateExpire->format(\DateTime::ISO8601);
        }
        $data = json_encode($data);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));

        $token = $iv . openssl_encrypt($data, $this->method, $this->key, 0, $iv);
        return $this->base64url_encode($token);
    }
}
