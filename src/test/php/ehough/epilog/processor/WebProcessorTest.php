<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_epilog_processor_WebProcessorTest extends ehough_epilog_TestCase
{
    public function testProcessor()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'HTTP_REFERER'   => 'D',
            'SERVER_NAME'    => 'F',
            'UNIQUE_ID'      => 'G',
        );

        $processor = new ehough_epilog_processor_WebProcessor($server);
        $record = call_user_func(array($processor, '__invoke'), $this->getRecord());
        $this->assertEquals($server['REQUEST_URI'], $record['extra']['url']);
        $this->assertEquals($server['REMOTE_ADDR'], $record['extra']['ip']);
        $this->assertEquals($server['REQUEST_METHOD'], $record['extra']['http_method']);
        $this->assertEquals($server['HTTP_REFERER'], $record['extra']['referrer']);
        $this->assertEquals($server['SERVER_NAME'], $record['extra']['server']);
        $this->assertEquals($server['UNIQUE_ID'], $record['extra']['unique_id']);
    }

    public function testProcessorDoNothingIfNoRequestUri()
    {
        $server = array(
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
        );
        $processor = new ehough_epilog_processor_WebProcessor($server);
        $record = call_user_func(array($processor, '__invoke'), $this->getRecord());
        $this->assertEmpty($record['extra']);
    }

    public function testProcessorReturnNullIfNoHttpReferer()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );
        $processor = new ehough_epilog_processor_WebProcessor($server);
        $record = call_user_func(array($processor, '__invoke'), $this->getRecord());
        $this->assertNull($record['extra']['referrer']);
    }

    public function testProcessorDoesNotAddUniqueIdIfNotPresent()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );
        $processor = new ehough_epilog_processor_WebProcessor($server);
        $record = $processor->__invoke($this->getRecord());
        $this->assertFalse(isset($record['extra']['unique_id']));
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testInvalidData()
    {
        new ehough_epilog_processor_WebProcessor(new stdClass);
    }
}
