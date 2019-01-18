<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Client Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $secret
 * @property string $redirect_uri
 * @property string $grant_type
 * @property string $scope
 * @property bool $revoked
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\AccessToken[] $access_tokens
 * @property \App\Model\Entity\AuthorizationCode[] $authorization_codes
 */
class Client extends Entity implements ClientEntityInterface
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'name' => true,
        'secret' => true,
        'redirect_uri' => true,
        'grant_type' => true,
        'scope' => true,
        'revoked' => true,
        'user' => true,
        'access_tokens' => true,
        'authorization_codes' => true
    ];

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }
}
