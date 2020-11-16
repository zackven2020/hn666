<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;

class OrderController extends BaseController
{
    /**
     * @var \App\Model\\App\Models\Order
     */
    protected $model;
    
    /**
     * UsersController constructor.
     *
     * @param \App\Model\User $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }
    
    /**
     * 创建订单
     */
    public function initOrder(Request $request)
    {
        /*$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);*/
        //$order = $this->model->create($request->post());
        $data = $request->post();
        return response()->success('红牛彩票提供',$data);
    }
    
    /**
     * 获取列表
     */
    public function lists(){
        $orders = Order::paginate(10);
        return OrderResource::collection($orders);
    }
}
