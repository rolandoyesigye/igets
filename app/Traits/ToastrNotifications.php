<?php

namespace App\Traits;

trait ToastrNotifications
{
    /**
     * Show a success toast notification
     */
    protected function toastSuccess($message)
    {
        return back()->with('success', $message);
    }

    /**
     * Show an error toast notification
     */
    protected function toastError($message)
    {
        return back()->with('error', $message);
    }

    /**
     * Show a warning toast notification
     */
    protected function toastWarning($message)
    {
        return back()->with('warning', $message);
    }

    /**
     * Show an info toast notification
     */
    protected function toastInfo($message)
    {
        return back()->with('info', $message);
    }

    /**
     * Show a success toast notification and redirect
     */
    protected function toastSuccessRedirect($message, $route = null)
    {
        if ($route) {
            return redirect()->route($route)->with('success', $message);
        }
        return redirect()->back()->with('success', $message);
    }

    /**
     * Show an error toast notification and redirect
     */
    protected function toastErrorRedirect($message, $route = null)
    {
        if ($route) {
            return redirect()->route($route)->with('error', $message);
        }
        return redirect()->back()->with('error', $message);
    }
} 