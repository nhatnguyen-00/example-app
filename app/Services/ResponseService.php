<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseService
{
    private array $res;

    public function __construct()
    {
        $this->res['data'] = [];
        $this->res['msg'] = 'Successfully';
    }

    public function setCode(int $code): self
    {
        $this->res['code'] = $code;

        return $this;
    }

    public function setMsg(string $msg): self
    {
        $this->res['msg'] = $msg;

        return $this;
    }

    public function setData($data = []): self
    {
        $this->res['data'] = $data;

        return $this;
    }

    public function setSuccess(): self
    {
        $this->setCode(Response::HTTP_OK);

        return $this;
    }

    public function setErr(): self
    {
        $this->setCode(Response::HTTP_BAD_REQUEST)
            ->setMsg('Page not found');

        return $this;
    }

    public function getErr(): JsonResponse
    {
        return $this->setErr()->get();
    }

    public function getSuccess($data = []): JsonResponse
    {
        return $this->setSuccess()->setData($data)->get();
    }

    public function getPaginator(LengthAwarePaginator $paginator, string $resourceClass): JsonResponse
    {
        $data = [
            'current_page' => $paginator->currentPage(),
            'results' => $resourceClass::collection($paginator->getCollection()),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];

        return $this->setSuccess()->setData($data)->get();
    }

    public function get(): JsonResponse
    {
        return response()->json($this->res, $this->res['code']);
    }
}
