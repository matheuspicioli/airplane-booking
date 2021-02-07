<?php

namespace Tests\Unit;

use App\Contexts\ReserveFiveSeat;
use App\Contexts\ReserveFourSeat;
use App\Contexts\ReserveOneSeat;
use App\Contexts\ReserveSevenSeat;
use App\Contexts\ReserveSixSeat;
use App\Contexts\ReserveThreeSeat;
use App\Contexts\ReserveTwoSeat;
use App\Contexts\SeatContext;
use Tests\TestCase;

class SeatTest extends TestCase
{
    public function test_reserve_one_seat()
    {
        $context    = new SeatContext(new ReserveOneSeat);
        $seats      = $context->reserve(1, 1, 'A', 1)->toArray();
        $this->assertCount(1, $seats);
    }

    public function test_reserve_two_seat()
    {
        $context    = new SeatContext(new ReserveTwoSeat);
        $seats      = $context->reserve(1, 1, 'A', 2)->toArray();
        $this->assertCount(2, $seats);
    }

    public function test_reserve_three_seat()
    {
        $context    = new SeatContext(new ReserveThreeSeat);
        $seats      = $context->reserve(1, 1, 'A', 3)->toArray();
        $this->assertCount(3, $seats);
    }

    public function test_reserve_four_seat()
    {
        $context    = new SeatContext(new ReserveFourSeat);
        $seats      = $context->reserve(1, 1, 'A', 4)->toArray();
        $this->assertCount(4, $seats);
    }

    public function test_reserve_five_seat()
    {
        $context    = new SeatContext(new ReserveFiveSeat);
        $seats      = $context->reserve(1, 1, 'A', 5)->toArray();
        $this->assertCount(5, $seats);
    }

    public function test_reserve_six_seat()
    {
        $context    = new SeatContext(new ReserveSixSeat);
        $seats      = $context->reserve(1, 1, 'A', 6)->toArray();
        $this->assertCount(6, $seats);
    }

    public function test_reserve_seven_seat()
    {
        $context    = new SeatContext(new ReserveSevenSeat);
        $seats      = $context->reserve(1, 1, 'A', 7)->toArray();
        $this->assertCount(7, $seats);
    }

    public function test_reserve_one_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveOneSeat);
        $seats      = $context->reserve(1, 1, 'F', 1);
        $this->assertCount(1, $seats->toArray());
        $this->assertEquals(1, $seats->last()->row);
        $this->assertEquals('F', $seats->last()->column);
    }

    public function test_reserve_two_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveTwoSeat);
        $seats      = $context->reserve(1, 2, 'E', 2);
        $this->assertCount(2, $seats->toArray());
        $this->assertEquals(2, $seats->last()->row);
        $this->assertEquals('F', $seats->last()->column);
    }

    public function test_reserve_three_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveThreeSeat);
        $seats      = $context->reserve(1, 5, 'F', 3);
        $this->assertCount(3, $seats->toArray());
        $this->assertEquals(6, $seats->last()->row);
        $this->assertEquals('E', $seats->last()->column);
    }

    public function test_reserve_four_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveFourSeat);
        $seats      = $context->reserve(1, 4, 'C', 4);
        $this->assertCount(4, $seats->toArray());
        $this->assertEquals(5, $seats->last()->row);
        $this->assertEquals('C', $seats->last()->column);
    }

    public function test_reserve_five_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveFiveSeat);
        $seats      = $context->reserve(1, 3, 'B', 5);
        $this->assertCount(5, $seats->toArray());
        $this->assertNotEquals(3, $seats->last()->row);
        $this->assertEquals('C', $seats->last()->column);
    }

    public function test_reserve_six_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveSixSeat);
        $seats      = $context->reserve(1, 3, 'D', 6);
        $this->assertCount(6, $seats->toArray());
        $this->assertNotEquals(3, $seats->last()->row);
        $this->assertEquals('F', $seats->last()->column);
    }

    public function test_reserve_seven_seat_and_assert_last_position()
    {
        $context    = new SeatContext(new ReserveSevenSeat);
        $seats      = $context->reserve(1, 4, 'F', 7);
        $this->assertCount(7, $seats->toArray());
        $this->assertNotEquals(5, $seats->last()->row);
        $this->assertEquals('F', $seats->last()->column);
    }
}
