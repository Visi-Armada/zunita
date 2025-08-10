<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuditService;
use Symfony\Component\HttpFoundation\Response;

class SecurityAuditMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users and specific routes
        if (auth()->check() && $this->shouldLogRoute($request)) {
            $this->logRequest($request, $response);
        }

        return $response;
    }

    /**
     * Determine if this route should be logged
     */
    private function shouldLogRoute(Request $request): bool
    {
        $routeName = $request->route()?->getName();
        
        // Routes to log
        $loggableRoutes = [
            'contributions.store',
            'contributions.update',
            'contributions.destroy',
            'contributions.approve',
            'contributions.reject',
            'contributions.export',
            'users.store',
            'users.update',
            'users.destroy',
            'initiatives.store',
            'initiatives.update',
            'initiatives.destroy',
            'applications.store',
            'applications.update',
            'applications.approve',
            'applications.reject',
        ];

        return in_array($routeName, $loggableRoutes);
    }

    /**
     * Log the request
     */
    private function logRequest(Request $request, Response $response): void
    {
        $routeName = $request->route()?->getName();
        $method = $request->method();
        
        // Determine action based on route and method
        $action = $this->determineAction($routeName, $method);
        
        // Determine model type from route
        $modelType = $this->determineModelType($routeName);
        
        // Get model ID if available
        $modelId = $request->route()?->parameter('contribution') ?? 
                   $request->route()?->parameter('user') ?? 
                   $request->route()?->parameter('initiative') ?? 
                   $request->route()?->parameter('application');
        
        // Get model identifier
        $modelIdentifier = $this->getModelIdentifier($request, $modelType);
        
        // Log the action
        AuditService::logDataChange(
            $action,
            $modelType,
            $modelId,
            $modelIdentifier,
            null, // old values (would need to be captured before update)
            $request->except(['password', 'password_confirmation', '_token']), // new values
            null, // changed fields
        );
    }

    /**
     * Determine action based on route and method
     */
    private function determineAction(?string $routeName, string $method): string
    {
        if (!$routeName) {
            return 'unknown';
        }

        // Map route names to actions
        $actionMap = [
            'contributions.store' => 'create',
            'contributions.update' => 'update',
            'contributions.destroy' => 'delete',
            'contributions.approve' => 'approve',
            'contributions.reject' => 'reject',
            'contributions.export' => 'export',
            'users.store' => 'create',
            'users.update' => 'update',
            'users.destroy' => 'delete',
            'initiatives.store' => 'create',
            'initiatives.update' => 'update',
            'initiatives.destroy' => 'delete',
            'applications.store' => 'create',
            'applications.update' => 'update',
            'applications.approve' => 'approve',
            'applications.reject' => 'reject',
        ];

        return $actionMap[$routeName] ?? 'unknown';
    }

    /**
     * Determine model type from route
     */
    private function determineModelType(?string $routeName): ?string
    {
        if (!$routeName) {
            return null;
        }

        if (str_contains($routeName, 'contributions')) {
            return 'Contribution';
        }

        if (str_contains($routeName, 'users')) {
            return 'User';
        }

        if (str_contains($routeName, 'initiatives')) {
            return 'Initiative';
        }

        if (str_contains($routeName, 'applications')) {
            return 'Application';
        }

        return null;
    }

    /**
     * Get model identifier
     */
    private function getModelIdentifier(Request $request, ?string $modelType): ?string
    {
        if ($modelType === 'Contribution') {
            return $request->input('voucher_number');
        }

        if ($modelType === 'User') {
            return $request->input('email');
        }

        if ($modelType === 'Initiative') {
            return $request->input('title');
        }

        if ($modelType === 'Application') {
            return $request->input('id');
        }

        return null;
    }
}
