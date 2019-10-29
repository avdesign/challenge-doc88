<?php
namespace App\Exceptions;

use Whoops\Exception\ErrorException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionTrait
{
    public function apiException($request,$e)
    {
        if ($this->isQuery($e)) {
            return $this->QueryResponse($e);
        }

        if ($this->isModel($e)) {
            return $this->ModelResponse($e);
        }

        if ($this->isMethod($e)) {
            return $this->MethodResponse($e);
        }

        if ($this->isHttp($e)) {
            return $this->HttpResponse($e);
        }

        if ($this->isError($e)) {
            return $this->ErrorResponse($e);
        }

        return parent::render($request, $e);

    }

    protected function isQuery($e)
    {
        return $e instanceof QueryException;
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isMethod($e)
    {
       return $e instanceof MethodNotAllowedHttpException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function isError($e)
    {
        return $e instanceof ErrorResponse;
    }


    protected function QueryResponse($e)
    {
        return response()->json([
            'errors' => 'Incorect Query '.$e,
        ],Response::HTTP_NOT_FOUND);
    }

    protected function ModelResponse($e)
    {
        return response()->json([
            'errors' => 'Not Found'
        ],Response::HTTP_NOT_FOUND);
    }

    protected function MethodResponse($e)
    {
        return response()->json( [
            'errors' => 'Method is not allowed for the requested route'.$e,
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    protected function HttpResponse($e)
    {
        return response()->json([
            'errors' => 'Not Found'
        ],Response::HTTP_NOT_FOUND);
    }

    protected function ErrorResponse($e)
    {
        return response()->json([
            'errors' => 'HTTP Iinternal server error'
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}