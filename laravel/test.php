<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$s3Client = new S3Client([
    'version' => 'latest',
    'region' => 'ap-northeast-1',
]);

$bucketName = 'あなたのバケット名';

try {
    $result = $s3Client->listObjectsV2([
        'Bucket' => $bucketName,
    ]);

    if (count($result['Contents']) > 0) {
        foreach ($result['Contents'] as $object) {
            echo $object['Key'] . "\n";
        }
    } else {
        echo "バケット '$bucketName' は空です。\n";
    }
} catch (AwsException $e) {
    // エラー処理
    echo $e->getMessage() . "\n";
}
