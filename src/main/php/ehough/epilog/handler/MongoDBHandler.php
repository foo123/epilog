<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Thomas Tourlourat <thomas@tourlourat.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//namespace Monolog\Handler;

//use Monolog\Logger;
//use Monolog\Formatter\NormalizerFormatter;

/**
 * Logs to a MongoDB database.
 *
 * usage example:
 *
 *   $log = new Logger('application');
 *   $mongodb = new MongoDBHandler(new \Mongo("mongodb://localhost:27017"), "logs", "prod");
 *   $log->pushHandler($mongodb);
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class ehough_epilog_handler_MongoDBHandler extends ehough_epilog_handler_AbstractProcessingHandler
{
    private $mongoCollection;

    public function __construct($mongo, $database, $collection, $level = ehough_epilog_Logger::DEBUG, $bubble = true)
    {
        if (!($mongo instanceof MongoClient || $mongo instanceof Mongo)) {
            throw new InvalidArgumentException('MongoClient or Mongo instance required');
        }

        $this->mongoCollection = $mongo->selectCollection($database, $collection);

        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        $this->mongoCollection->save($record["formatted"]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new ehough_epilog_formatter_NormalizerFormatter();
    }
}