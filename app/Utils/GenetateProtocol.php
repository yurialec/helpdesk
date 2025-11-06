<?php
namespace App\Utils;

use App\Models\Admin\Ticket;
use Carbon\Carbon;

class GenetateProtocol
{
    public static function generate()
    {
        $dt = Carbon::now()->format('my');

        $currentMonth = Carbon::now();
        $tickets = Ticket::whereMonth('created_at', $currentMonth->month)->count() + 1;

        if ((strlen($tickets) === 1)) {
            $value = '0000' . $tickets;
        } else {
            $trimmedString = substr('0000', 0, -strlen($tickets));
            $value = $trimmedString . $tickets;
        }


        return 'P' . $value . $dt;
    }
}