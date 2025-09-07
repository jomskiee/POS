<?php

namespace App\Models;

use App\Constants\RoleStatusConstant;
use App\Constants\UserStatusConstant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function broker(): HasOne
    {
        return $this->hasOne(Broker::class);
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function isBroker(): bool
    {
        return $this->role === RoleStatusConstant::BROKER;
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleStatusConstant::ADMIN;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatusConstant::ACTIVE;
    }

    public function isDeactivated(): bool
    {
        return $this->status === UserStatusConstant::DEACTIVATED;
    }

    public function scopeBrokers($query)
    {
        return $query->where('role', RoleStatusConstant::BROKER);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', RoleStatusConstant::ADMIN);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatusConstant::ACTIVE);
    }

    public function scopeDeactivated($query)
    {
        return $query->where('status', UserStatusConstant::DEACTIVATED);
    }

    /**
     * Create a new user with role-specific profile
     */
    public static function createUserWithRole(array $userData, array $profileData = []): self
    {
        $user = static::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role' => $userData['role'],
            'status' => UserStatusConstant::ACTIVE,
        ]);

        // Create role-specific profile using dynamic method call
        $profileClass = $user->getProfileClass();
        $profileClass::createProfile($user->id, $profileData);

        return $user;
    }

    /**
     * Update user status and sync with profile
     */
    public function updateStatus(string $status): bool
    {
        $this->status = $status;
        $this->save();

        // Sync status with profile using dynamic method call
        $profile = $this->getProfile();
        if ($profile) {
            $profile->update(['status' => $status]);
        }

        return true;
    }

    /**
     * Delete user profile (broker only, admin cannot be deleted)
     */
    public function deleteProfile(): bool
    {
        if ($this->isBroker()) {
            $broker = $this->broker;
            if ($broker) {
                return $broker->deleteBroker();
            }
        }

        return false;
    }

    /**
     * Update user profile data (handles both admin and broker)
     */
    public function updateProfile(array $profileData): bool
    {
        $profile = $this->getProfile();
        if ($profile) {
            return $profile->updateProfile($profileData);
        }

        return false;
    }

    /**
     * Get the profile model (admin or broker)
     */
    public function getProfile()
    {
        return $this->{$this->getProfileRelation()} ?? null;
    }

    /**
     * Get the profile relation name based on role
     */
    private function getProfileRelation(): string
    {
        return $this->role === RoleStatusConstant::ADMIN ? 'admin' : 'broker';
    }

    /**
     * Get the profile class based on role
     */
    private function getProfileClass(): string
    {
        return $this->role === RoleStatusConstant::ADMIN ? Admin::class : Broker::class;
    }
}
