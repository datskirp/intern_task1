<?php

namespace App\Services;

class BlockByIp
{
    private const TABLE_NAME = 'login_block';
    private const LOG_TABLE = 'login_block_log';
    public const BLOCK_TIMEOUT = 60 * 1;
    private static Db $db;
    private static string $ip;

    public function __construct()
    {
        self::$db = Db::getInstance();
        self::$ip = $_SERVER['REMOTE_ADDR'];
    }

    public function getRecord(): array|false
    {
        $record = self::$db->select(['*'])
            ->from(self::TABLE_NAME)
            ->where(['ip' => self::$ip], '= :')
            ->getOne();

        if (isset($record['begin_attempts']) && time() - $record['begin_attempts'] > self::BLOCK_TIMEOUT) {
            $this->unBlock();

            return false;
        }

        return $record;
    }


    public function isAllowed(): bool
    {
        $record = $this->getRecord();
        if ($record) {
            return $record['attempts'] <= 3;
        }

        return true;
    }

    public function addAttempt(): int|false
    {
        $record = $this->getRecord();
        if ($record) {
            $record['attempts']++;
            self::$db->update(self::TABLE_NAME)
                ->set(['attempts' => $record['attempts'], 'begin_attempts' => time()])
                ->where(['ip' => self::$ip], '= :')
                ->do();

            return $record['attempts'];
        }
        $this->addFirstAttempt();

        return 1;
    }

    private function addFirstAttempt(): void
    {
        self::$db->insert(self::TABLE_NAME)
            ->columns(['ip', 'attempts', 'begin_attempts'])
            ->values(['ip' => self::$ip, 'attempts' => 1, 'begin_attempts' => time()])
            ->do();
    }

    public function block(string $email): void
    {
        $timeout = time() + self::BLOCK_TIMEOUT;
        self::$db->update(self::TABLE_NAME)
            ->set(['end_block' => $timeout])
            ->where(['ip' => self::$ip], '= :')
            ->do();
        $this->createLogBlock($email, $timeout);
    }

    private function createLogBlock(string $email, int $timeout)
    {
        $dateFormat = 'Y-m-d H:i:s';
        $startBlock = date($dateFormat, time());
        $endBlock = date($dateFormat, $timeout);
        self::$db->insert(self::LOG_TABLE)
            ->columns(['ip', 'email', 'start_block', 'end_block'])
            ->values(['ip' => self::$ip, 'email' => $email, 'startBlock' => $startBlock, 'endBlock' => $endBlock])
            ->do();
    }

    public function unBlock(): void
    {
        self::$db->delete(self::TABLE_NAME)
            ->where(['ip' => self::$ip], '= :')
            ->do();
    }

    public function isBlocked(): bool
    {
        $record = $this->getRecord();
        if ($record) {
            if (!is_null($record['end_block']) && $record['end_block'] < time()) {
                $this->unBlock();

                return false;
            }
            if (!is_null($record['end_block']) && $record['end_block'] > time()) {
                return true;
            }
        }

        return false;
    }
}
