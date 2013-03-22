<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//namespace Monolog\Handler;

//use Monolog\Logger;

/**
 * Used for testing purposes.
 *
 * It records all records and gives you access to them for verification.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ehough_epilog_handler_TestHandler extends ehough_epilog_handler_AbstractProcessingHandler
{
    protected $records = array();
    protected $recordsByLevel = array();

    public function getRecords()
    {
        return $this->records;
    }

    public function hasEmergency($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::EMERGENCY);
    }

    public function hasAlert($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::ALERT);
    }

    public function hasCritical($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::CRITICAL);
    }

    public function hasError($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::ERROR);
    }

    public function hasWarning($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::WARNING);
    }

    public function hasNotice($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::NOTICE);
    }

    public function hasInfo($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::INFO);
    }

    public function hasDebug($record)
    {
        return $this->hasRecord($record, ehough_epilog_Logger::DEBUG);
    }

    public function hasEmergencyRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::EMERGENCY]);
    }

    public function hasAlertRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::ALERT]);
    }

    public function hasCriticalRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::CRITICAL]);
    }

    public function hasErrorRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::ERROR]);
    }

    public function hasWarningRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::WARNING]);
    }

    public function hasNoticeRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::NOTICE]);
    }

    public function hasInfoRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::INFO]);
    }

    public function hasDebugRecords()
    {
        return isset($this->recordsByLevel[ehough_epilog_Logger::DEBUG]);
    }

    protected function hasRecord($record, $level)
    {
        if (!isset($this->recordsByLevel[$level])) {
            return false;
        }

        if (is_array($record)) {
            $record = $record['message'];
        }

        foreach ($this->recordsByLevel[$level] as $rec) {
            if ($rec['message'] === $record) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
    }
}
