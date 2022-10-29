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
        $record = self::$db->getRecord(
            'SELECT `ip`, `attempts`, `end_block`, `begin_attempts` FROM `' . self::TABLE_NAME . '` WHERE `ip` = INET_ATON(:ip);',
            ['ip' => self::$ip]
        );
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
            self::$db->changeRecord(
                'UPDATE `' . self::TABLE_NAME . '` SET `attempts` = :attempts,
                `begin_attempts` = UNIX_TIMESTAMP() WHERE `ip` = INET_ATON(:ip);',
                ['attempts' => $record['attempts'], 'ip' => self::$ip]
            );

            return $record['attempts'];
        }
        $this->addFirstAttempt();

        return 1;
    }

    private function addFirstAttempt(): void
    {
        self::$db->changeRecord(
            'INSERT INTO `' . self::TABLE_NAME . '` (`ip`, `attempts`, `begin_attempts`) VALUES (INET_ATON(:ip), :attempts, UNIX_TIMESTAMP());',
            ['ip' => self::$ip, 'attempts' => 1]
        );
    }

    public function block(string $email): void
    {
        $timeout = time() + self::BLOCK_TIMEOUT;
        self::$db->changeRecord(
            'UPDATE `' . self::TABLE_NAME . '` SET `end_block` = :endBlock WHERE `ip` = INET_ATON(:ip);',
            ['endBlock' => $timeout, 'ip' => self::$ip]
        );
        $this->createLogBlock($email, $timeout);
    }

    private function createLogBlock(string $email, int $timeout)
    {
        $dateFormat = 'Y-m-d H:i:s';
        $startBlock = date($dateFormat, time());
        $endBlock = date($dateFormat, $timeout);
        self::$db->changeRecord(
            'INSERT INTO `' . self::LOG_TABLE . '` (`ip`, `email`, `start_block`, `end_block`) VALUES
            (INET_ATON(:ip), :email, :startBlock, :endBlock);',
            ['ip' => self::$ip, 'email' => $email, 'startBlock' => $startBlock, 'endBlock' => $endBlock]
        );
    }

    public function unBlock(): void
    {
        self::$db->changeRecord(
            'DELETE FROM `' . self::TABLE_NAME . '` WHERE `ip` = INET_ATON(:ip);',
            ['ip' => self::$ip]
        );
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
