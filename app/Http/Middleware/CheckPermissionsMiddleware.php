<?php

namespace App\Http\Middleware;

use App\Post;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        list($controller, $method) = explode('@', $request->route()->getActionName());
        $controller = str_replace(['App\Http\Controllers\Backend\\', 'Controller'], '', $controller);

        $crudPermissionsMap = [
            //'create' => ['create', 'store'],
            //'update' => ['edit', 'update'],
            //'delete' => ['destroy', 'restore', 'forceDestroy'],
            //'read' => ['index', 'view']
            'crud' => ['create', 'store', 'edit', 'update', 'destroy', 'restore', 'forceDestroy', 'index', 'view']
        ];

        $classesMap = [
            'Blog' => 'post',
            'Category' => 'category',
            'User' => 'user'
        ];

        foreach($crudPermissionsMap as $permission=>$methods)
        {
            if(in_array($method, $methods) && isset($classesMap[$controller]))
            {
                $currentUser = $request->user();
                $className = $classesMap[$controller];
                if($className == 'post' && in_array($method, ['edit', 'update', 'destroy', 'restore', 'forceDestroy']))
                {
                    if((!$currentUser->owns(Post::withTrashed()->findOrFail($request->route('blog')), 'author_id')) && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')))
                    {
                        abort(Response::HTTP_FORBIDDEN, 'Forbidden access!');
                    }
                }
                elseif(!$currentUser->can("{$permission}-{$className}"))
                {
                    abort(Response::HTTP_FORBIDDEN, 'Forbidden access!');
                }
                break;
            }
        }

        return $next($request);
    }
}
