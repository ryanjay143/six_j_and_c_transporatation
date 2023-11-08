<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Ivolo\DisposableEmails\Detector;


class EmailVerificationService
{
    public function verifyEmail($email)
    {
        $detector = new Detector();
    
        if ($detector->isDisposable($email)) {
            return false; // Email is disposable
        }
    
        // Email is not disposable
        return true;
    }
}
