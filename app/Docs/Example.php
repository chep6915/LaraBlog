<?php

/**
 *  @OA\Post(
 *      path="/login",
 *      summary="Sign in",
 *      description="Swagger測試範例",
 *      operationId="authLogin",
 *      tags={"example"},
 *      @OA\RequestBody(
 *          required=true,
 *          description="Pass user credentials",
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *              @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *              @OA\Property(property="persistent", type="boolean", example="true"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Wrong credentials response",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again"),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      format="query",
 *                      @OA\Property(property="name", type="string" , example="Sorry"),
 *                      @OA\Property(property="category", type="string" , example="Sorry"),
 *                  ),
 *              ),
 *              @OA\Property(
 *                  property="datas",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                      format="query",
 *                  ),
 *                  example="[]"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      format="query",
 *                      @OA\Property(
 *                          property="email",
 *                          type="array",
 *                          collectionFormat="multi",
 *                          @OA\Items(
 *                              type="string",
 *                              example={"The email field is required.","The email must be a valid email address."},
 *                          )
 *                      )
 *                  )
 *              ),
 *              @OA\Property(
 *                  property="prom1",
 *                  type="object",
 *                  @OA\Property(
 *                      property="email",
 *                      type="array",
 *                      collectionFormat="multi",
 *                      @OA\Items(
 *                          type="string",
 *                          example={"The email field is required.","The email must be a valid email address."},
 *                      )
 *                  )
 *              ),
 *          )
 *      )
 * )
 *
 *
 */

