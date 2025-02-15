<?php

namespace Ynet;

class Auth
{
    protected $secret;
    
    public function __construct($secret)
    {
        $this->secret = $secret;
    }
    
    public function generateToken($userId, $expiration = 3600)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        $payload = json_encode([
            'user_id' => $userId,
            'exp' => time() + $expiration
        ]);
        
        $base64Header = $this->base64UrlEncode($header);
        $base64Payload = $this->base64UrlEncode($payload);
        
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $this->secret, true);
        $base64Signature = $this->base64UrlEncode($signature);
        
        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }
    
    public function validateToken($token)
    {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return false;
        }
        
        $header = $this->base64UrlDecode($parts[0]);
        $payload = $this->base64UrlDecode($parts[1]);
        $signature = $this->base64UrlDecode($parts[2]);
        
        $headerObj = json_decode($header);
        $payloadObj = json_decode($payload);
        
        if ($payloadObj->exp < time()) {
            return false;
        }
        
        $calculatedSignature = hash_hmac('sha256', $parts[0] . '.' . $parts[1], $this->secret, true);
        
        return hash_equals($signature, $calculatedSignature) ? $payloadObj : false;
    }
    
    protected function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    protected function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}