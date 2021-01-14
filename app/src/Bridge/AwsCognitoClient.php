<?php

namespace App\Bridge;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;
use Aws\Result;
use Aws\Credentials\Credentials;

class AwsCognitoClient
{
    private CognitoIdentityProviderClient $client;

    private string $poolId;

    private string $clientId;

    public function __construct(
        string $poolId,
        string $clientId
    ) {
        $this->client = new CognitoIdentityProviderClient([
            'region' => "eu-west-1",
            'version' => 'latest'
        ]);

        $this->poolId = $poolId;
        $this->clientId = $clientId;
    }

    public function getPoolList()
    {
        try {
            $result = $this->client->listUsers([
                'UserPoolId' => 'eu-west-1_02YJX3OJe'
            ]);
//            foreach ($result['IdentityPools'] as $identityPool) {
//                echo "IdentityPoolId - " . $identityPool["IdentityPoolId"] ;
//                echo " , IdentityPoolName - " . $identityPool["IdentityPoolName"] ."\n";
//            }
//            var_dump($result);

            return $result;
        } catch (\Exception $e) {
            // output error message if fails
            echo $e->getMessage() . "\n";
        }
    }

    public function checkCredentials(string $username,string $password): Result
    {
        return $this->client->adminInitiateAuth([
            'UserPoolId'     => $this->poolId,
            'ClientId'       => $this->clientId,
            'AuthFlow'       => 'ADMIN_NO_SRP_AUTH', // this matches the 'server-based sign-in' checkbox setting from earlier
            'AuthParameters' => [
                'USERNAME' => $username,
                'PASSWORD' => $password
            ]
        ]);
    }

    public function getRolesForUsername(string $username): Result
    {
        return $this->client->adminListGroupsForUser([
            'UserPoolId' => $this->poolId,
            'Username'   => $username
        ]);
    }

    public function findByUsername(string $username): Result
    {
        return $this->client->listUsers([
            'UserPoolId' => $this->poolId,
            'Filter'     => "email=\"" . $username . "\""
        ]);
    }
}
