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
 * @OA\Post(
 *      path="/api/adminUser",
 *      operationId="articles",
 *      tags={"Admin"},
 *      summary="取得文章列表 Summary",
 *      description="取得文章列表 Description",
 *      @OA\Response(
 *          response=200,
 *          description="請求成功"
 *       )
 * )
 * Returns list of articles
 */
