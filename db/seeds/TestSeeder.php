<?php


use Phinx\Seed\AbstractSeed;

class TestSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
	    $query = <<<EOQ
Insert into test values (null, 'test', 1, NOW(), NOW());
EOQ;
		$this->execute($query);
    }
}
