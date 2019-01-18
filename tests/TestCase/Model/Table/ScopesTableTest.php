<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScopesTable Test Case
 */
class ScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScopesTable
     */
    public $Scopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Scopes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Scopes') ? [] : ['className' => ScopesTable::class];
        $this->Scopes = TableRegistry::getTableLocator()->get('Scopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Scopes);

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
}
