<?php

/**
 * This helper function seems to be unnecessary, but good to know how to create these kind in Laravel
 * -> check the composer file for setting the autoload
 */

use App\Post;
use Symfony\Component\HttpFoundation\Request;

function check_user_permissions(Request $request, $actionName = null, $id = null)
{
    if($actionName)
    {
        $currentActionName = $actionName;
    }
    else
    {
        $currentActionName = $request->route()->getActionName();
    }
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
                $id = !is_null($id) ? $id : $request->route('blog');
                if((!$currentUser->owns(Post::withTrashed()->findOrFail($id), 'author_id')) && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')))
                {
                    return false;
                }
            }
            elseif(!$currentUser->can("{$permission}-{$className}"))
            {
                return false;
            }
            break;
        }
    }

    return true;
}