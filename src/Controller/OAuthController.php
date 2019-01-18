<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Zend\Diactoros\Stream;

/**
 * OAuth Controller
 *
 * @property \League\OAuth2\Server\AuthorizationServer $OAuthServer
 * @property \App\Model\Table\AccessTokensTable $AccessTokens
 * @property \App\Model\Table\AuthorizationCodesTable $AuthorizationCodes
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\RefreshTokensTable $RefreshTokens
 * @property \App\Model\Table\ScopesTable $Scopes
 * @property \App\Model\Table\UsersTable $Users
 */
class OAuthController extends AppController
{
    public function initialize()
    {
        $this->loadModel('AccessTokens');
        $this->loadModel('Clients');
        $this->loadModel('RefreshTokens');
        $this->loadModel('Scopes');
        $this->loadModel('Users');

        $privateKey = 'file://path/to/private.key';
        $encryptionKey = 'LaygedYkxXnBTCJsFLOLBDAZTaGt+BMCZxA4CzVxaAI=';

        $this->OAuthServer = new AuthorizationServer(
            $this->Clients,
            $this->AccessTokens,
            $this->Scopes,
            $privateKey,
            $encryptionKey
        );

        // Add listeners
        $this->OAuthServer->getEmitter()->addListener(
            'clients.authentication.failed',
            function (\League\OAuth2\Server\RequestEvent $event) {
                // do something
            }
        );

        $this->OAuthServer->getEmitter()->addListener(
            'user.authentication.failed',
            function (\League\OAuth2\Server\RequestEvent $event) {
//                $this->getRequest()->getData('user_id');
            }
        );
    }

    public function beforeFilter(Event $event)
    {
        $grant_type = $this->getRequest()->getData('grant_type');

        switch ($grant_type) {
            case 'authorization_code':
                $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
                    $this->AuthorizationCodes,
                    $this->RefreshTokens,
                    new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
                );

                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

                // Enable the authentication code grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'client_credentials':
                // Enable the client credentials grant on the server
                $this->OAuthServer->enableGrantType(
                    new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'password':
                $grant = new \League\OAuth2\Server\Grant\PasswordGrant($this->Users, $this->RefreshTokens);

                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

                // Enable the password grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'refresh_token':
                $grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($this->RefreshTokens);
                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // new refresh tokens will expire after 1 month

                // Enable the refresh token grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // new access tokens will expire after an hour
                );
                break;
            default:
                throw new BadRequestException("Unknown grant type: $grant_type");
        }
    }

    public function oauth()
    {

    }

    public function authorize()
    {
        $this->loadModel('AuthorizationCodes');
        $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
            $this->AuthorizationCodesTable,
            $this->RefreshTokens,
            new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
        );

        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

        // Enable the authentication code grant on the server
        $this->OAuthServer->enableGrantType(
            $grant,
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );

        try {

            // Validate the HTTP request and return an AuthorizationRequest object.
            $authRequest = $this->OAuthServer->validateAuthorizationRequest($this->getRequest());

            // The auth request object can be serialized and saved into a user's session.
            // You will probably want to redirect the user at this point to a login endpoint.

            // Once the user has logged in set the user on the AuthorizationRequest
            $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface

            // At this point you should redirect the user to an authorization page.
            // This form will ask the user to approve the client and the scopes requested.

            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);

            // Return the HTTP redirect response
            return $$this->server->completeAuthorizationRequest($authRequest, $this->getResponse());

        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($this->getResponse());

        } catch (\Exception $exception) {

            // Unknown exception
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());
            return $this->getResponse()->withStatus(500)->withBody($body);

        }
    }

    public function accessToken()
    {
        $data = $this->getRequest()->getData();
        $grant_type = $data['grant_type'] ?? null;
        $client_id = $data['client_id'] ?? null;
        $client_secret = $data['client_secret'] ?? null;
        $scope = $data['scope'] ?? null;

        if (!$grant_type || !$client_id || !$client_secret || !$scope) {
            throw new BadRequestException();
        }

        switch ($grant_type) {
            case 'client_credentials':
                break;
            case 'password':
                $username = $data['username'] ?? null;
                $password = $data['password'] ?? null;

                if (!$username || !$password) {
                    throw new BadRequestException();
                }
                break;
            case 'refresh_token':
                $refresh_token = $data['refresh_token'] ?? null;

                if (!$refresh_token) {
                    throw new BadRequestException();
                }
                break;
            default:
                throw new BadRequestException("Unknown grant type: $grant_type");
        }
        try {
            // Try to respond to the request
            return $this->OAuthServer->respondToAccessTokenRequest($this->getRequest(), $this->getResponse());

        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($this->getResponse());

        } catch (\Exception $exception) {

            // Unknown exception
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());
            return $this->getResponse()->withStatus(500)->withBody($body);

        }
    }
}
