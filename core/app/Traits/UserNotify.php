<?php
namespace App\Traits;

use App\Constants\Status;

trait UserNotify
{
    public static function notifyToUser(){
        return [
            'allUsers'              => 'All Users',
            'selectedUsers'         => 'Selected Users',
            'hasPaid'               => 'Paid Users',
            'notPaidUsers'          => 'Not Paid Users',
            'pendingPaidUsers'      => 'Pending Paid Users',
            'rejectedPaidUsers'     => 'Rejected Paid Users',
            'topPaidUsers'          => 'Top Paid Users',
            'pendingTicketUser'     => 'Pending Ticket Users',
            'answerTicketUser'      => 'Answer Ticket Users',
            'closedTicketUser'      => 'Closed Ticket Users',
            'notLoginUsers'         => 'Last Few Days Not Login Users',
        ];
    }

    public function scopeSelectedUsers($query)
    {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllUsers($query)
    {
        return $query;
    }

    public function scopeEmptyBalanceUsers($query)
    {
        return $query->where('balance', '<=', 0);
    }

    public function scopeHasPaid($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        });
    }

    public function scopeNotPaidUsers($query)
    {
        return $query->whereDoesntHave('deposits', function ($q) {
            $q->successful();
        });
    }

    public function scopePendingPaidUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->pending();
        });
    }

    public function scopeRejectedPaidUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->rejected();
        });
    }

    public function scopeTopPaidUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        })->withSum(['deposits'=>function($q){
            $q->successful();
        }], 'amount')->orderBy('deposits_sum_amount', 'desc')->take(request()->number_of_top_deposited_user ?? 10);
    }

    public function scopePendingTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY]);
        });
    }

    public function scopeClosedTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->where('status', Status::TICKET_CLOSE);
        });
    }

    public function scopeAnswerTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {

            $q->where('status', Status::TICKET_ANSWER);
        });
    }

    public function scopeNotLoginUsers($query)
    {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

}
