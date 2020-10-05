<?php
// Copyright (C) <2018>  <it-novum GmbH>
//
// This file is dual licensed
//
// 1.
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, version 3 of the License.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// 2.
//  If you purchased an openITCOCKPIT Enterprise Edition you can use this file
//  under the terms of the openITCOCKPIT Enterprise Edition license agreement.
//  License agreement and license key will be shipped with the order
//  confirmation.

namespace itnovum\openITCOCKPIT\oAuth;

use App\Model\Table\SystemsettingsTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class oAuthClient {

    // Good docs:
    // https://packagist.org/packages/league/oauth2-client

    /**
     * @var GenericProvider
     */
    private $Provider;

    /**
     * @var string
     */
    private $logoutUrl;

    /**
     * oAuthClient constructor.
     * Basically just a wrapper class for League\OAuth2\Client\Provider\GenericProvider
     * to avoid copy&past of the Systemsettings stuff to different locations
     */
    public function __construct() {

        /** @var SystemsettingsTable $SystemsettingsTable */
        $SystemsettingsTable = TableRegistry::getTableLocator()->get('Systemsettings');

        $config = $SystemsettingsTable->getOAuthConfig();

        // Internal oAuth Test Server
        //$config = $this->getLocalTestConfig();

        $this->Provider = $this->getAuthProvider($config);

        $this->logoutUrl = $config['FRONTEND.SSO.LOG_OFF_LINK'];
    }

    /**
     * Builds the authorization URL.
     *
     * @param array $options
     * @return string Authorization URL
     */
    public function getAuthorizationUrl(array $options = []) {
        return $this->Provider->getAuthorizationUrl($options);
    }

    /**
     * Returns the current value of the state parameter.
     *
     * This can be accessed by the redirect handler during authorization.
     *
     * @return string
     */
    public function getState() {
        return $this->Provider->getState();
    }

    /**
     * Requests an access token using a specified grant and option set.
     *
     * @param mixed $grant
     * @param array $options
     * @return AccessToken|AccessTokenInterface
     * @throws IdentityProviderException
     */
    public function getAccessToken($grant, array $options = []) {
        return $this->Provider->getAccessToken($grant, $options);
    }

    /**
     * Requests and returns the resource owner of given access token.
     *
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    public function getResourceOwner(AccessToken $token) {
        return $this->Provider->getResourceOwner($token);
    }

    public function getLogoutUrl() {
        return $this->logoutUrl;
    }

    /**
     * @param array $config
     * @return GenericProvider
     */
    protected function getAuthProvider(array $config) {
        switch ($config['FRONTEND.SSO.AUTH_PROVIDER']) {
            case 'PingIdentity':
                return new GenericProvider([
                    'clientId'                => $config['FRONTEND.SSO.CLIENT_ID'],       // The client ID assigned to you by the provider
                    'clientSecret'            => $config['FRONTEND.SSO.CLIENT_SECRET'],   // The client password assigned to you by the provider
                    'redirectUri'             => Router::url(['controller' => 'users', 'action' => 'login'], true), //Login screen of openITCOCKPIT itself
                    'urlAuthorize'            => $config['FRONTEND.SSO.AUTH_ENDPOINT'],   //Login screen
                    'urlAccessToken'          => $config['FRONTEND.SSO.TOKEN_ENDPOINT'],  //Where to get the access token from
                    'urlResourceOwnerDetails' => $config['FRONTEND.SSO.USER_ENDPOINT'],    // Where to get user information from

                    'accessTokenResourceOwnerId' => 'id',
                    'scopeSeparator'             => ' ',
                    'scopes'                     => [
                        'openid',
                        'profile'
                    ]
                ]);

            default:
                return new GenericProvider([
                    'clientId'                => $config['FRONTEND.SSO.CLIENT_ID'],       // The client ID assigned to you by the provider
                    'clientSecret'            => $config['FRONTEND.SSO.CLIENT_SECRET'],   // The client password assigned to you by the provider
                    'redirectUri'             => Router::url(['controller' => 'users', 'action' => 'login'], true), //Login screen of openITCOCKPIT itself
                    'urlAuthorize'            => $config['FRONTEND.SSO.AUTH_ENDPOINT'],   //Login screen
                    'urlAccessToken'          => $config['FRONTEND.SSO.TOKEN_ENDPOINT'],  //Where to get the access token from
                    'urlResourceOwnerDetails' => $config['FRONTEND.SSO.USER_ENDPOINT']    // Where to get user information from
                ]);
        }
    }

    private function getLocalTestConfig() {
        return [
            'FRONTEND.SSO.CLIENT_ID'      => 'abc123',         // The client ID assigned to you by the provider         // oitc sys var: FRONTEND.SSO.CLIENT_ID
            'FRONTEND.SSO.CLIENT_SECRET'  => 'ssh-secret',     // The client password assigned to you by the provider   // oitc sys var: FRONTEND.SSO.CLIENT_SECRET
            'redirectUri'                 => Router::url(['controller' => 'users', 'action' => 'login'], true),     // Login screen of openITCOCKPIT itself
            'FRONTEND.SSO.AUTH_ENDPOINT'  => 'http://192.168.1.207:3001/dialog/authorize', // oitc sys var: FRONTEND.SSO.AUTH_ENDPOINT
            'FRONTEND.SSO.TOKEN_ENDPOINT' => 'http://192.168.1.207:3001/oauth/token',      // oitc sys var: FRONTEND.SSO.TOKEN_ENDPOINT
            'FRONTEND.SSO.USER_ENDPOINT'  => 'http://192.168.1.207:3001/api/userinfo',     // oitc sys var: FRONTEND.SSO.USER_ENDPOINT
            'FRONTEND.SSO.LOG_OFF_LINK'   => 'http://192.168.1.207:3001/logout'

        ];
    }
}
