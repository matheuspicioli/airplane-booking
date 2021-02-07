<?php declare(strict_types=1);

namespace App\DTO;

use App\Models\Booking;
use App\Repository\Contracts\BookingRepositoryContract;
use Spatie\DataTransferObject\DataTransferObject;

class SeatData extends DataTransferObject
{
    public string $column;
    public int $row;
    public Booking $booking;

    public static function fromArray(array $data): self
    {
        $booking_repository = app(BookingRepositoryContract::class);
        $booking = $booking_repository->findOrFail($data['booking_id']);

        return new self([
            'column'     => $data['column'],
            'row'        => $data['row'],
            'booking'    => $booking
        ]);
    }
}
