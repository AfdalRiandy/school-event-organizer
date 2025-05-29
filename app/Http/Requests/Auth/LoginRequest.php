<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Siswa;
use App\Models\WakilKesiswaan;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'credential' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credential = $this->input('credential');
        $password = $this->input('password');
        $user = null;

        // Check if credential is an email (for admin/panitia)
        if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $credential, 'password' => $password], $this->boolean('remember'))) {
                RateLimiter::clear($this->throttleKey());
                return;
            }
        } 
        // Check if credential is NIS (for students)
        else {
            // Try to find user by NIS
            $siswa = Siswa::where('nis', $credential)->first();
            if ($siswa) {
                $user = User::find($siswa->user_id);
                if ($user && Auth::attempt(['email' => $user->email, 'password' => $password], $this->boolean('remember'))) {
                    RateLimiter::clear($this->throttleKey());
                    return;
                }
            }

            // If not student, try to find by NIP (wakil kesiswaan)
            $wakilKesiswaan = WakilKesiswaan::where('nip', $credential)->first();
            if ($wakilKesiswaan) {
                $user = User::find($wakilKesiswaan->user_id);
                if ($user && Auth::attempt(['email' => $user->email, 'password' => $password], $this->boolean('remember'))) {
                    RateLimiter::clear($this->throttleKey());
                    return;
                }
            }
        }

        // If we reach here, authentication failed
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('credential')).'|'.$this->ip());
    }
}