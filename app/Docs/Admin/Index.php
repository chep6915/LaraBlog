<?php
/**
 * @OA\Post (
 *      path="/index/Login",
 *      operationId="Index",
 *      tags={"Index"},
 *      summary="登入",
 *      description="登入",
 *      @OA\Parameter(
 *          name="account",
 *          description="帳號",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              maximum=10,
 *          )
 *      ),
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

