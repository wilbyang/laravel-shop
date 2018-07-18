<?php

namespace App\Notifications;

use App\Models\CouponCode;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class ReferringUserNotification extends Notification
{
    use Queueable;

    protected $coupon;

    public function __construct(CouponCode $coupon)
    {
        $this->coupon = $coupon;
    }

    // 我们只需要通过邮件通知，因此这里只需要一个 mail 即可
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $code = $this->coupon->code;
        $expire_date = $this->coupon->not_after->format('m-d H:i');
        return (new MailMessage)
                    ->subject('北欧胜品推广奖励')
                    ->greeting('您好：有一个人通过您的推广链接注册了')
                    ->line("您将获得一个九折优惠的打折码: $code ，该优惠码将于一个月内过期，请于 $expire_date 之前使用。")
                    ->success(); // 按钮的色调
    }
}
