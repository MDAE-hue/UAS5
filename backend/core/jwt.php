<?php

class JWT {

    private static $secret = "TOKEN_SANGAT_RAHASIA_JANGAN_DISEBAR";

    public static function encode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64Header = self::base64UrlEncode($header);

        $base64Payload = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64Header . "." . $base64Payload, self::$secret, true);
        $base64Signature = self::base64UrlEncode($signature);

        return "$base64Header.$base64Payload.$base64Signature";
    }

    public static function decode($token) {
        $parts = explode(".", $token);
        if (count($parts) !== 3) return false;

        list($header, $payload, $signature) = $parts;

        $check = hash_hmac('sha256', "$header.$payload", self::$secret, true);
        $validSignature = self::base64UrlEncode($check);

        if ($validSignature !== $signature) return false;

        return json_decode(self::base64UrlDecode($payload), true);
    }

    private static function base64UrlEncode($text) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    private static function base64UrlDecode($text) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $text));
    }
}
