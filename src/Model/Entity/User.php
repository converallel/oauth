<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $phone_number
 * @property \Cake\I18n\FrozenTime|null $email_verified_at
 * @property \Cake\I18n\FrozenTime|null $phone_number_verified_at
 * @property int $failed_login_attempts
 * @property string $password
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \App\Model\Entity\AccessToken[] $access_tokens
 * @property \App\Model\Entity\AuthorizationCode[] $authorization_codes
 * @property \App\Model\Entity\Client[] $clients
 * @property \App\Model\Entity\Contact[] $contacts
 */
class User extends Entity implements UserEntityInterface
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
        'email' => true,
        'phone_number' => true,
        'email_verified_at' => true,
        'phone_number_verified_at' => true,
        'failed_login_attempts' => true,
        'password' => true,
        'access_tokens' => true,
        'authorization_codes' => true,
        'clients' => true,
        'contacts' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
