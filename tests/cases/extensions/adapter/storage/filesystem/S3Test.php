<?php

namespace li3_aws\tests\cases\extensions\adapter\storage\filesystem;

use li3_aws\extensions\adapter\storage\filesystem\S3;

class S3Test extends \lithium\test\Unit {
    protected $configuration = array(
		'bucket' => 'li3awstest',
	);

	public function setUp() {
		$this->s3 = new S3($this->configuration);
	}

	public function tearDown() {
		unset($this->s3);
	}

	public function testSimpleWrite() {
		$filename = 'test_file';
		$data = 'test data';

		$params = compact('filename', 'data');
		$result = $this->s3->write($filename, $data);
		$this->assertTrue($result);

	}

	public function testSimpleRead(){
		$filename = 'test_file';
		print_r($this->s3->read($filename, array('url_only' => true)));
	}

}
