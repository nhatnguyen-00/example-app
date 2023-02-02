<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

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

    public function setData(array $data = []): self
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

    public function getSuccess(array $data = []): JsonResponse
    {
        return $this->setSuccess()->setData($data)->get();
    }

    public function get(): JsonResponse
    {
        return response()->json($this->res);
    }
}
