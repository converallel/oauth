<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Scope Entity
 *
 * @property int $id
 * @property string $description
 */
class Scope extends Entity implements ScopeEntityInterface
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
        'description' => true
    ];

    /**
     * Get the scope's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
