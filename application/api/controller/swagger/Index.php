<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/4/20
 * Time: 16:32
 */

namespace app\api\controller\swagger;

use think\Controller;

/**
 * swagger_php后端集成类
 *
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host=API_HOST,
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="敦百系统接口说明文档",
 *         description="接口返回统一格式{code, data, msg},详细介绍请查看页面Model中res_json说明",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="sessionliang@outlook.com"
 *         )
 *     )
 * )
 */
class Index extends Controller
{
    public function index(){
        $path = APP_PATH.'api'; //你想要哪个文件夹下面的注释生成对应的API文档
        $swagger = \Swagger\scan($path);
        $swagger_json_path = APP_PATH.'../public/swagger/swagger.json';
        $res = file_put_contents($swagger_json_path, $swagger);
        if ($res == true) {
            $this->redirect(request()->domain().'/swagger/swagger-ui/dist/index.html');
        }
    }
}