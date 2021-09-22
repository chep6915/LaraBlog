<?php
/**
 *  @OA\Post (
 *      path="/api/index/login",
 *      operationId="index",
 *      tags={"Index"},
 *      summary="登入",
 *      description="使用信箱及密碼登入",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Pass user credentials",
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property(property="email", type="string", format="email", example="admin@qq.com"),
 *              @OA\Property(property="password", type="string", format="password", example="1234qwer"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="參數錯誤",
 *          @OA\JsonContent(
 *              @OA\Property(property="code", type="integer", example="300000"),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                      format="query",
 *                  ),
 *                  example="[]"
 *              ),
 *              @OA\Property(property="total", type="integer", example="0"),
 *              @OA\Property(property="msg", type="string", example="The given data was invalid."),
 *              @OA\Property(
 *                  property="error",
 *                  type="array",
 *                  @OA\Items(
 *                  type="object",
 *                  format="query",
 *                  @OA\Property(property="name", type="string"),
 *                  @OA\Property(property="category", type="string")
 *                  )
 *              )
 *          )
 *      ),
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
