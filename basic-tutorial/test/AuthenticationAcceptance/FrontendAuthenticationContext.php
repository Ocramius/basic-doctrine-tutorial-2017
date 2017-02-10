<?php

declare(strict_types=1);

namespace AuthenticationAcceptance;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Assert;

final class FrontendAuthenticationContext implements Context
{
    /**
     * @Given there are no registered users
     */
    public function there_are_no_registered_users() : void
    {
        /* @var $entityManager EntityManagerInterface */
        $entityManager = require __DIR__ . '/../../bootstrap.php';

        $schemaTool = new SchemaTool($entityManager);

        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * @When a user registers with the website
     */
    public function a_user_registers_with_the_website() : void
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://localhost:8080/register.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query([
                'emailAddress' => 'me@example.com',
                'password'     => 'pa$$w0RD',
            ])
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        Assert::assertTrue(false !== strpos('Correctly registered!', $server_output));
    }
}
