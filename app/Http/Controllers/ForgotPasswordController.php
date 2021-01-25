<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Http\Requests\ResetPasswordResquest;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use App\Http\Requests\OtpRequest;
use App\Jobs\SendOtpMailJob;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Profile\ProfileRepositoryInterface;

class ForgotPasswordController extends Controller
{
    protected $userRepo;

    public function __construct(
        ProfileRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function forgotPassword()
    {
        return view('auth/forgot-password');
    }

    public function getEmail(Request $request)
    {
        $user = $this->userRepo->getUserByEmail($request->email);

        if ($user->count() == config('count.count_1')) {
            $userUpdate = $this->updateOTP($this->userRepo->getUserFirstByEmail($request->email)->email);
            
            $details = [
                'otp' => $userUpdate->first()->OTP,
                'email' => $userUpdate->first()->email,
            ];
        
            SendOtpMailJob::dispatch($details);
            
            return view('auth/confirm-otp', compact('user'));
        }

        return redirect()->route('login');
    }

    public function updateOTP($email)
    {
        $user = $this->userRepo->getUserFirstByEmail($email);
        $updateOtp = $this->userRepo->updateOtpWhenFindEmail($email);

        if ($updateOtp) {
            return $user;
        }

        return redirect()->route('get_email');
    }

    public function confirmOtp(OtpRequest $request, $email)
    {
        $user = $this->userRepo->getUserFirstByEmail($email);
        $otpUser = $this->userRepo->getOTPUser($email);
        $otpType = $request->otp;
        if ($otpType == '') {
            return redirect()->route('login');
        }

        if ($otpUser === $otpType) {
            return view('auth/send-email', compact('user'));
        } else {
            toastr()->error( trans('log_res.opt_not_found') );

            return redirect()->route('forgot.password');
        }
    }

    public function ressetPassword(ResetPasswordResquest $request, $email)
    {
        $user = $this->userRepo->getUserByEmail($email);

        if ($user->count() == config('count.count_1')) {
            $this->userRepo->updatePasswordAndOtp($email, $request->password);
            
            return redirect()->route('login');
        } else {
            toastr()->error( trans('log_res.update_fail') );

            return redirect()->route('forgot.password');
        }
    }
}
