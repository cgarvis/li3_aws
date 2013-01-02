<?php

namespace li3_aws\tests\cases\extensions\adapter\storage\filesystem;

use li3_aws\extensions\adapter\storage\filesystem\S3;

class S3Test extends \lithium\test\Unit {
    protected $configuration = array(
		'bucket' => 'li3awstest',
		'key' => '...',
		'secret' => '...'
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

	public function testSimpleReadUrl(){

		$filename = 'test_file';
		$expected = "http://{$this->configuration['bucket']}.s3.amazonaws.com/{$filename}";
		$this->assertEqual($expected, $this->s3->read($filename, array('url_only' => true)));

	}

	public function testFileExists(){

		$filename = 'test_file';
		$this->assertTrue($this->s3->exists($filename));

	}

	public function testFileNotExists(){

		$filename = 'test_no_file';
		$this->assertFalse($this->s3->exists($filename));

	}

	public function testBucketExists(){
		$this->assertTrue($this->s3->exists());
	}

	public function testBucketNotExists(){
		$this->configuration['bucket'] = 'li3awsnobucket';
		$this->s3 = new S3($this->configuration);
		$this->assertFalse($this->s3->exists());
		unset($this->s3);
	}

}
