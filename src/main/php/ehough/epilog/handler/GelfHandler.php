<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handler to send messages to a Graylog2 (http://www.graylog2.org) server
 *
 * @author Matt Lehner <mlehner@gmail.com>
 * @author Benjamin Zikarsky <benjamin@zikarsky.de>
 */
class ehough_epilog_handler_GelfHandler extends ehough_epilog_handler_AbstractProcessingHandler
{
    /**
     * @var Publisher the publisher object that sends the message to the server
     */
    protected $publisher;

    /**
     * @param PublisherInterface|IMessagePublisher $publisher a publisher object
     * @param integer                              $level     The minimum logging level at which this handler will be triggered
     * @param boolean                              $bubble    Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($publisher, $level = ehough_epilog_Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        if (!$publisher instanceof Gelf\IMessagePublisher && !$publisher instanceof Gelf\PublisherInterface) {
            throw new InvalidArgumentException("Invalid publisher, expected a Gelf\IMessagePublisher or Gelf\PublisherInterface instance");
        }

        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->publisher = null;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->publisher->publish($record['formatted']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new ehough_epilog_formatter_GelfMessageFormatter();
    }
}
