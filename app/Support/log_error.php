<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

if (!function_exists('log_error')) {
    /**
     * Smart error handler & logger.
     *
     * - Logs full context (exception class, file, line, trace, request info, user id)
     * - Handles ValidationException, QueryException, and others automatically
     * - Returns redirect with proper flash or validation errors
     *
     * Usage:
     *   try {
     *       // your logic
     *   } catch (\Throwable $e) {
     *       return log_error($e);
     *   }
     *
     * @param \Throwable|string $error
     * @param array $context Optional extra data
     * @return \Illuminate\Http\RedirectResponse|void
     */
    function log_error($error, array $context = [])
    {
        $request = request();

        // Basic log context
        $baseContext = array_merge($context, [
            'url'      => $request->fullUrl() ?? null,
            'user_id'  => optional(auth())->id(),
            'inputs'   => $request->except(['password', '_token']),
            'ip'       => $request->ip(),
            'method'   => $request->method(),
        ]);

        // Handle plain strings
        if (!($error instanceof \Throwable)) {
            Log::error((string) $error, $baseContext);
            return back()->with('error', 'An unexpected error occurred.');
        }

        // Build detailed exception context
        $exceptionContext = array_merge($baseContext, [
            'exception' => get_class($error),
            'message'   => $error->getMessage(),
            'file'      => $error->getFile(),
            'line'      => $error->getLine(),
            'trace'     => $error->getTraceAsString(),
        ]);

        // -------- [1] Validation Exception -------- //
        if ($error instanceof ValidationException) {
            Log::warning('Validation failed', $exceptionContext);
            return back()->withInput()->withErrors($error->errors());
        }

        // -------- [2] Database / Query Exception -------- //
        if ($error instanceof QueryException) {
            $exceptionContext['sql']      = $error->getSql();
            $exceptionContext['bindings'] = $error->getBindings();
            Log::error('Database error', $exceptionContext);

            $message = 'A database error occurred while saving. Please review your data.';
            if (App::environment('local')) {
                $message .= ' (' . $error->getMessage() . ')';
            }

            // Optionally detect common invalid date errors
            if (str_contains($error->getMessage(), 'Incorrect date value')) {
                return back()->withInput()->withErrors([
                    'date' => 'Invalid date format. Please use YYYY-MM-DD.',
                ]);
            }

            return back()->withInput()->with('error', $message);
        }

        // -------- [3] Unexpected Exception -------- //
        Log::error('Unexpected exception', $exceptionContext);

        $message = 'Something went wrong. Please try again or contact support.';
        if (App::environment('local')) {
            $message .= ' (' . $error->getMessage() . ')';
        }

        return back()->withInput()->with('error', $message);
        // return back();
    }
}
