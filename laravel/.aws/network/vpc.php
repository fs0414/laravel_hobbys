<?php

require 'vendor/autoload.php';

use Aws\Ec2\Ec2Client;
use Aws\Exception\AwsException;

$ec2Client = new Ec2Client([
    'version' => 'latest',
    'region'  => 'ap-northeast-1',
]);

$existingVpcs = $ec2Client->describeVpcs();

$vpcName = 'sdk-php-vpc-01';

try {
    foreach ($existingVpcs['Vpcs'] as $vpc) {
        if (isset($vpc['Tags'])) {
            foreach ($vpc['Tags'] as $tag) {
                if ($tag['Key'] == 'Name' && $tag['Value'] == $vpcName) {
                    $vpcExists = true;
                    $existingVpcId = $vpc['VpcId'];
                    break 2;
                }
            }
        }
    }

    if ($vpcExists) {
        echo "VPC named '{$vpcName}' already exists. VPC ID: {$existingVpcId}\n";
    } else {
        $result = $ec2Client->createVpc([
            'CidrBlock' => '10.0.0.0/16',
        ]);
        $vpcId = $result['Vpc']['VpcId'];
        echo "VPC created: {$vpcId}\n";

        $ec2Client->createTags([
            'Resources' => [$vpcId],
            'Tags' => [
                [
                    'Key' => 'Name',
                    'Value' => $vpcName,
                ],
            ],
        ]);
        echo "VPC named '{$vpcName}'\n";

        // create subnet
        $result = $ec2Client->createSubnet([
            'AvailabilityZone' => 'ap-northeast-1a',
            'CidrBlock' => '10.0.1.0/24',
            'VpcId' => $vpcId,
        ]);

        $ec2Client->createTags([
            'Resources' => [$result['Subnet']['SubnetId']],
            'Tags' => [
                [
                    'Key' => 'Name',
                    'Value' => 'sdk-php-subnet-01',
                ],
            ],
        ]);
    }
} catch (AwsException $e) {
    echo $e->getMessage();
    echo "\n";
}

