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

		$closure = $this->s3->write($filename, $data);
		$this->assertTrue(is_callable($closure));

		$result = $closure($filename, $data);
		$this->assertTrue($result);

	}

	public function testSimpleReadUrl(){

		$filename = 'test_file';

		$closure = $this->s3->read($filename, array());
		$this->assertTrue(is_callable($closure));

		$expected = "http://{$this->configuration['bucket']}.s3.amazonaws.com/{$filename}";
		$result = $closure($filename, array('url_only' => true));

		$this->assertEqual($expected, $result);

	}

	public function testFileExists(){

		$filename = 'test_file';
		$closure = $this->s3->exists($filename);
		$this->assertTrue(is_callable($closure));

		$result = $closure($filename, array());

		$this->assertTrue($result);

	}

	public function testFileNotExists(){

		$filename = 'test_no_file';
		$closure = $this->s3->exists($filename);
		$this->assertTrue(is_callable($closure));

		$result = $closure($filename, array());

		$this->assertFalse($result);

	}

	public function testBucketExists(){

		$closure = $this->s3->exists();
		$this->assertTrue(is_callable($closure));

		$result = $closure(null, array());

		$this->assertTrue($result);

	}

	public function testBucketNotExists(){

		$this->configuration['bucket'] = 'li3awsnobucket';
		$this->s3 = new S3($this->configuration);

		$closure = $this->s3->exists();
		$this->assertTrue(is_callable($closure));
		$result = $closure(null, array());
		$this->assertFalse($result);
		unset($this->s3);

	}

	public function testFileUpload(){
	}

}
