<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest\Command;

use Phue\Command\GetLightById;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetLightById
 */
class GetLightByIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getTransport'],
            ['127.0.0.1']
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Stub client's getUsername method
        $this->mockClient->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('abcdefabcdef01234567890123456789'));

        // Stub client getTransport usage
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
    }

    /**
     * Test: Send get light by id command
     *
     * @covers \Phue\Command\GetLightById::__construct
     * @covers \Phue\Command\GetLightById::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with("{$this->mockClient->getUsername()}/lights/10")
            ->will($this->returnValue(new \stdClass));

        // Get light
        $light = (new GetLightById(10))->send($this->mockClient);

        // Ensure type is correct
        $this->assertInstanceOf(
            '\Phue\Light',
            $light
        );
    }
}