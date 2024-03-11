<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-northeast-1',
    //'region'  => getenv('AWS_REGION'),
]);

$buketName = 'sdk-php-buket-01';

try {
    $result = $s3->createBucket([
        'Bucket' => $buketName,
    ]);

    // $bucketPolicy = [
    //     'Version' => '2012-10-17',
    //     'Statement' => [
    //         [
    //             'Sid' => 'AddPerm',
    //             'Effect' => 'Allow',
    //             'Principal' => '*',
    //             'Action' => 's3:GetObject',
    //             'Resource' => "arn:aws:s3:::{$bucketName}/*",
    //             'Condition' => [
    //                 'IpAddress' => ['aws:SourceIp' => 'YOUR.IP.ADD.RESS']
    //             ]
    //         ]
    //     ]
    // ];

    // $s3->putBucketPolicy([
    //     'Bucket' => $bucketName,
    //     'Policy' => json_encode($bucketPolicy),
    // ]);

    echo 'Bucket created successfully';
} catch (AwsException $e) {
    echo $e->getMessage();
    echo "\n";
}
