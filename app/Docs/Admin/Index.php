<?php
/**
 * @OA\Get(
 *      path="/api/articles",
 *      operationId="articles",
 *      tags={"Article Tag"},
 *      summary="取得文章列表 Summary",
 *      description="取得文章列表 Description",
 *      @OA\Response(
 *          response=200,
 *          description="請求成功"
 *       )
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