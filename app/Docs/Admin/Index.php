<?php
/**
 * @OA\Post (
 *      path="/api/index/login",
 *      operationId="index",
 *      tags={"Index"},
 *      summary="登入",
 *      description="使用信箱及密碼登入",
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="admin@qq.com"),
 *       @OA\Property(property="password", type="string", format="password", example="1234qwer"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
 * )
 * )
 * Returns list of articles
 */

/**
 * @OA\Get(
 *      path="/api/articles/{id}",
 *      operationId="articleShow",
 *      tags={"Article"},
 *      summary="取得文章詳情",
 *      description="取得文章詳情",
 *      @OA\Parameter(
 *          name="id",
 *          description="Article id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="請求成功"
 *       ),
 *      @OA\Response(
 *          response=404,
 *          description="資源不存在"
 *       )
 * )
 * Show article content
 */

