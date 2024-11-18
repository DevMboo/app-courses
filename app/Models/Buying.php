<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    //
    protected $table = "buyings";

    protected $fillable = ['customer_id', 'payment_id', 'pix_qr_code', 'pix_qr_code_url','email','cpf','phone', 'user_id', 'price', 'course_id', 'status', 'request', 'error_reponse'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public static function hasPendingBuying(string $courseId, int $userId): bool
    {
        return Buying::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->whereNot('status', 'sent')
            ->exists();
    }

    public static function hasBuyingConfirmed(string $courseId, int $userId): bool
    {
        return Buying::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->where('status', 'payment_confirmed')
            ->exists();
    }

}
