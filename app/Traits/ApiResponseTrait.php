<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    /**
     * @var int
     */
    protected int $httpStatusCode = 200;

    /**
     * @var int
     */
    protected int $perPage = 10;

    /**
     * @var string
     */
    protected string $sort = 'created_at';

    /**
     * @var string
     */
    protected string $sortDirection = 'asc';

    /**
     * Get HTTP status code of the response.
     *
     * @return int
     */
    public function getHTTPStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Set HTTP status code of the response.
     *
     * @param int $statusCode
     * @return self
     */
    public function setHTTPStatusCode(int $statusCode): static
    {
        $this->httpStatusCode = $statusCode;

        return $this;
    }

    /**
     * Sends a JSON to the consumer.
     *
     * @param array $data
     * @param array $headers [description]
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []): JsonResponse
    {
        return response()->json($data, $this->getHTTPStatusCode(), $headers);
    }

    /**
     * Sends a response with success.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function respondOkay(string $message = 'OK'): JsonResponse
    {
        return $this->respond([
            'message' => $message,
        ]);
    }

    /**
     * Sends a response with error.
     *
     * @param array|string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function respondWithError(array|string $message = "Client Error", int $statusCode = 400): JsonResponse
    {
        $this->setHTTPStatusCode($statusCode);

        abort(response()->json([
            'message' => $message,
        ], $this->httpStatusCode));
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage($limit): static
    {
        $this->perPage = $limit;

        return $this;
    }

    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    public function getSortCriteria(): string
    {
        return $this->sort;
    }

    public function setSortCriteria($criteria): static
    {
        if (!$criteria) {
            return $this;
        }

        $this->sortDirection = $criteria[0] == '-' ? 'desc' : 'asc';
        $this->sort = ltrim($criteria, '-');

        return $this;
    }

    /**
     * Paginate the given collection.
     *
     * @param Collection $collection
     * @return JsonResponse
     */
    public function getPaginatedCollectionResponse(Collection $collection): JsonResponse
    {
        $perPage = $this->perPage;
        $page = LengthAwarePaginator::resolveCurrentPage();

        $slicedData = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginatedData = new LengthAwarePaginator($slicedData, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $respondArray = [
            'data' => $slicedData,
            'meta' => collect($paginatedData)->except('data')->toArray()
        ];

        return $this->respond($respondArray);
    }
}
