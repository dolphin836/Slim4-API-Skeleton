<?php
//
namespace Dolphin\Ting\Console\Queue;

class Config
{
    /**
     * @var string 虚拟主机
     */
    private $virtualHost;

    /**
     * @var string 交换机
     */
    private $exchange;

    /**
     * @var string 队列
     */
    private $queue;

    public function __construct ($config = [])
    {
        $this->setVirtualHost($config['virtualHost']);
        $this->setExchange($config['exchange']);
        $this->setQueue($config['queue']);
    }

    /**
     * @return string
     */
    public function getVirtualHost () : string
    {
        return $this->virtualHost;
    }

    /**
     * @param string $virtualHost
     */
    public function setVirtualHost (string $virtualHost) : void
    {
        $this->virtualHost = $virtualHost;
    }

    /**
     * @return string
     */
    public function getExchange () : string
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     */
    public function setExchange (string $exchange) : void
    {
        $this->exchange = $exchange;
    }

    /**
     * @return string
     */
    public function getQueue () : string
    {
        return $this->queue;
    }

    /**
     * @param string $queue
     */
    public function setQueue (string $queue) : void
    {
        $this->queue = $queue;
    }
}