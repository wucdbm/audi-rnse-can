<?php

namespace Wucdbm\AudiRnseCan;

readonly class CanBusConnection
{
    private \CanBus $can;

    /**
     * CanBus constructor.
     *
     * @param string $interface non-empty string
     */
    public function __construct(string $interface) {
        $this->can = new \CanBus($interface);
    }

    /**
     * Initializes CanBus interface and connects to unix sockets
     * If socket was initialized before, it closes previous connection
     *
     * @param bool $blocking Whether interface should be blocking or not
     * @return bool success/failure
     */
    public function init(bool $blocking = true): bool {
        return $this->can->init($blocking);
    }

    /**
     * Attempts to read single CanFrame.
     *
     * @return CanBusFrame|false CanFrame on success, false on failure
     */
    public function read(): CanBusFrame|false {
        $frame = $this->can->read();

        if (false === $frame) {
            return false;
        }

        return new CanBusFrame($frame->id, $frame->data);
    }

    /**
     * Attempts to send single CanFrame.
     *
     * @return bool success/failure
     */
    public function send(CanBusFrame $frame): bool {
        return $this->can->send(new \CanFrame($frame->getId(), $frame->getData()));
    }

    /**
     * Generates random CanFrame
     * ID: 0 to 0x7FF
     * Data: 0 to 8 bytes of values in range of 0 to 0xFF (0-255)
     *
     * @return CanBusFrame
     */
    public function generateRandomFrame(): CanBusFrame {
        $frame = $this->can->generateRandomFrame();

        return new CanBusFrame(
            $frame->id,
            $frame->data,
        );
    }
}
