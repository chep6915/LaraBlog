<?php
/**
 * 網站帳密登入
 * @OA\Post (
 *      path="/api/index/login",
 *      operationId="index",
 *      tags={"Index"},
 *      summary="網站帳密登入",
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
 *          response=200,
 *          description="請求成功",
 *          @OA\JsonContent(
 *              @OA\Property(property="code", type="integer", example="1"),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      format="query",
 *                      @OA\Property(property="id", type="integer" , example=1),
 *                      @OA\Property(property="avatar_original", type="string" , example="https://google.com"),
 *                      @OA\Property(property="avatar", type="string" , example="https://google.com"),
 *                      @OA\Property(property="picture", type="string" , example="https://google.com"),
 *                      @OA\Property(property="account", type="string" , example="admin"),
 *                      @OA\Property(property="name", type="string" , example="admin"),
 *                      @OA\Property(property="given_name", type="string" , example="Yun"),
 *                      @OA\Property(property="family_name", type="string" , example="Ma"),
 *                      @OA\Property(property="nickname", type="string" , example="LittleMa"),
 *                      @OA\Property(property="admin_user_group_id", type="integer" , example=1),
 *                      @OA\Property(property="email", type="string" , example="admin@qq.com"),
 *                      @OA\Property(property="email_verified_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="admin_user_last_ip", type="string" , example="127.0.0.1"),
 *                      @OA\Property(property="last_update_admin_user_id", type="integer" , example=1),
 *                      @OA\Property(property="locale", type="string" , example="zh-TW"),
 *                      @OA\Property(property="enable_password_login", type="integer" , example=0),
 *                      @OA\Property(property="Google_id", type="string" , example="12345"),
 *                      @OA\Property(property="is_frozen", type="integer" , example=0),
 *                      @OA\Property(property="created_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="updated_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="deleted_at", type="string" , example="null"),
 *                      @OA\Property(property="token", type="string" , example="269dbca6bcdfdd0249b2da5007282847#MTYzMjY2ODQ3NQ=="),
 *                  ),
 *              ),
 *          )
 *       ),
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
 *                  type="object",
 *                  @OA\Property(
 *                      property="email",
 *                      type="array",
 *                      @OA\Items(
 *                          type="string",
 *                          example="The email field is required.",
 *                      )
 *                  )
 *              ),
 *          )
 *      ),
 * )
 */

/**
 * Google登入
 * @OA\Post (
 *      path="/api/index/google/login",
 *      operationId="index/google/login",
 *      tags={"Index"},
 *      summary="Google登入",
 *      description="使用第三方Google登入",
 *      @OA\Response(
 *          response=200,
 *          description="請求成功",
 *          @OA\JsonContent(
 *              @OA\Property(property="code", type="integer", example="1"),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      format="query",
 *                      @OA\Property(property="id", type="integer" , example=1),
 *                      @OA\Property(property="avatar_original", type="string" , example="https://google.com"),
 *                      @OA\Property(property="avatar", type="string" , example="https://google.com"),
 *                      @OA\Property(property="picture", type="string" , example="https://google.com"),
 *                      @OA\Property(property="account", type="string" , example="admin"),
 *                      @OA\Property(property="name", type="string" , example="admin"),
 *                      @OA\Property(property="given_name", type="string" , example="Yun"),
 *                      @OA\Property(property="family_name", type="string" , example="Ma"),
 *                      @OA\Property(property="nickname", type="string" , example="LittleMa"),
 *                      @OA\Property(property="admin_user_group_id", type="integer" , example=1),
 *                      @OA\Property(property="email", type="string" , example="admin@qq.com"),
 *                      @OA\Property(property="email_verified_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="admin_user_last_ip", type="string" , example="127.0.0.1"),
 *                      @OA\Property(property="last_update_admin_user_id", type="integer" , example=1),
 *                      @OA\Property(property="locale", type="string" , example="zh-TW"),
 *                      @OA\Property(property="enable_password_login", type="integer" , example=0),
 *                      @OA\Property(property="Google_id", type="string" , example="12345"),
 *                      @OA\Property(property="is_frozen", type="integer" , example=0),
 *                      @OA\Property(property="created_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="updated_at", type="string" , example="2021-09-08 21:10:59"),
 *                      @OA\Property(property="deleted_at", type="string" , example="null"),
 *                      @OA\Property(property="token", type="string" , example="269dbca6bcdfdd0249b2da5007282847#MTYzMjY2ODQ3NQ=="),
 *                  ),
 *              ),
 *          )
 *       )
 * )
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
