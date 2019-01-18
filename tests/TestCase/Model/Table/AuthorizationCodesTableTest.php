<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuthorizationCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuthorizationCodesTable Test Case
 */
class AuthorizationCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AuthorizationCodesTable
     */
    public $AuthorizationCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AuthorizationCodes',
        'app.Users',
        'app.Clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AuthorizationCodes') ? [] : ['className' => AuthorizationCodesTable::class];
        $this->AuthorizationCodes = TableRegistry::getTableLocator()->get('AuthorizationCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AuthorizationCodes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
