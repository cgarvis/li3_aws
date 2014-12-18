<?php

namespace li3_aws\extensions\adapter\storage\filesystem;

/**
 * An Simple Storage Service (S3) filesystem adapter implementation.
 *
 * The S3 adapter is meant to be used through the `FileSystem` interface, which abstracts away
 * bucket creation, adapter instantiation, and filter implemenation.
 *
 * A simple configuration of this adapter can be accomplished in `config/bootstrap/filesystem.php`
 * as follows:
 *
 * {{{
 * FileSystem::config(array(
 *     'cloud' => 'array('adapter' => 'S3'),
 * ));
 * }}}
 *
 */
class S3 extends \lithium\core\Object {
    /**
     * Class constructor.
     *
     * @see li3_filesystem\storage\FileSystem::config()
     * @param array $config
     */
    public function __construct(array $config = array()) {
        $defaults = array(
            'key' => 'AKIAJCQJZKAWSTNVBHUQ',
            'secret' => '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',
            'bucket' => 'lithium',
            'region' => \AmazonS3::REGION_US_E1
        );
        parent::__construct($config + $defaults);
    }

    public function write($filename, $data, array $options = array()) {
        $s3 = new \AmazonS3($this->_config);;
        $bucket = $this->_config['bucket'];
        $region = $this->_config['region'];

        return function($self, $params) use ($s3, $bucket, $region) {
            $body = $params['data'];
            $filename = $params['filename'];

            if($s3->if_bucket_exists($bucket)) {
                // @TODO: implement logic when bucket exists
            } else {
                $s3->create_bucket($bucket, $region);
            }

            if($s3->if_object_exists($bucket, $filename)) {
                // @TODO: implement logic when file exists
            }

            return $s3->create_object($bucket, $filename, array(
                'acl' => \AmazonS3::ACL_PUBLIC,
                'body' => $body
            ));
        };
    }

    public function read($filename, array $options = array()) {

    }

    public function delete($filename, array $options = array()) {
        $s3 = new \AmazonS3($this->_config);;
        $bucket = $this->_config['bucket'];
        $region = $this->_config['region'];

        return function($self, $params) use ($s3, $bucket, $region) {
            $filename = $params['filename'];

            return $s3->delete_object($bucket, $filename, array(
                'acl' => \AmazonS3::ACL_PUBLIC
            ));
        };
    }
}
