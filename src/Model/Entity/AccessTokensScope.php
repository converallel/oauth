<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccessTokensScope Entity
 *
 * @property string $access_token_id
 * @property string $scope_id
 *
 * @property \App\Model\Entity\AccessToken $access_token
 * @property \App\Model\Entity\Scope $scope
 */
class AccessTokensScope extends Entity
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
        'access_token' => true,
        'scope' => true
    ];
}
