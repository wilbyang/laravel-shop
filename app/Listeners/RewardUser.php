<?php

namespace App\Listeners;

use App\Events\UserReferred;
use App\Models\CouponCode;
use App\Models\ReferralLink;
use App\Models\ReferralRelationship;
use App\Notifications\ReferringUserNotification;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserReferred  $event
     * @return void
     */
    public function handle(UserReferred $event)
    {
        $referral = ReferralLink::find($event->referralId);
        if (!is_null($referral)) {
            ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);

            // Example...
            if ($referral->program->name === 'Signup_Bonus') {
                $referral_id = $referral->user->id;
                $newbie_id = $event->user->id;
                $coupon = CouponCode::create([
                    'name' => "$referral_id ref $newbie_id",
                    'code' => CouponCode::findAvailableCode(8),
                    'type' => 'percent',
                    'value' => 0,
                    'total' => 2,
                    'used' => 0,
                    'min_amount' => 0,
                    'not_before' => Carbon::now(),
                    'not_after' => Carbon::now()->addDays(30),
                    'enabled' => TRUE,
                ]);
                $referral->user->notify(new ReferringUserNotification($coupon));

            }

        }
    }
}
