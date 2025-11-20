<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Determine whether the user can view any reports.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the report.
     */
    public function view(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }

    /**
     * Determine whether the user can create reports.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the report.
     */
    public function update(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }

    /**
     * Determine whether the user can delete the report.
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }

    /**
     * Determine whether the user can restore the report.
     */
    public function restore(User $user, Report $report): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the report.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return false;
    }
}
