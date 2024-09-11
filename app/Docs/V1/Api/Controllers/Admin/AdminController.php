<?php

namespace App\Docs\V1\Api\Controllers\Admin;

use App\Docs\V1\Api\Controllers\Controller;

class AdminController extends Controller {

    /**
     * @OA\Get(
     *      path="/api/v1/customer/get",
     *      operationId="getCustomer",
     *      tags={"Customers"},
     *      summary="Get logged in customer details",
     *      description="Get logged in customer details",
     *      security={ {"sanctum": {} }},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Customer"
     *              )
     *          )
     *       ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function get()
    {
    }
}
