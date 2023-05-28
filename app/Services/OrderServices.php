<?php

namespace App\Services;

use App\Basket\Basket;
use App\interfaces\ServicesContract;
use App\Models\Order;
use App\Models\SupCategory;
use App\Models\User;
use App\Traits\CalculateNewPrice;
use DateTime;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderServices implements ServicesContract{

    use CalculateNewPrice;

    private $item , $customer ;


    public function __construct()
    {
        $this->item = new ItemServices(new SubCategoryServices);
        $this->customer = new CustomerServices;
    }
    
    /**
     * get orders and it user name
     */
    public function all()
    {
        $orders = Order::orderBy('id','ASC')->paginate(PAGINATION);

        if(is_null($orders))
            return $orders;

        foreach($orders as $order){
            $order->userName = OrderServices::getUserName($order);
        }
        return $orders;
    }

    /**
     * return orders that satisfy condition and return by paginate
     */
    public function getWhere($column,$operator,$value):?LengthAwarePaginator
    {
        return Order::where($column,$operator,$value)->paginate(PAGINATION);
    }

   
    public function getByID($id, ?array $columns = null)
    {
        if(count($columns)>0)
            return Order::select($columns)->findorfail($id);
        return Order::findorfail($id);
    }

    
    public function getLastOrder()
    {
        $order = Order::orderBy('created_at','DESC')->first();
        
        if($order !== null) {
            $order->sellerName = $order->seller()->select('name')->first()->name;
            $order->userName = $order->user()->select('name')->first()->name;
        }
        
        return $order;
    }

    public function getLastTwoOrder()
    {
        $orders = Order::orderBy('created_at','DESC')->offset(0)->limit(2)->get();
        
        foreach($orders as $order){
            $order->sellerName = $order->seller()->select('name')->first()->name;
            $order->userName = $order->user()->select('name')->first()->name;
        }
        
        return $orders;
    }

    public function orderCount() 
    {
        return Order::count();
    }

    

    /**
     * get specific items and all data of item by orderID
     */
    public function getItemsOfOrder($orderID)
    {
        $order = Order::findorfail($orderID);
        $items = $order->items()->paginate(PAGINATION);
        
        foreach($items as $item){

            $item->discount;
            if($item->discount!=null)
                $item->price = self::calcNewPrice($item->discount->discount_value,$item->price);

            $item->namespace = SupCategory::find($item->subcategory_id)->category->name;
            
            $item->subcategoryName = SupCategory::select('name')->findorfail($item->subcategory_id)->name;

            $item->makeHidden(['discount']);

        }

        return $items;
    }
    
    public function getColumnsByID($orderID,array $column)
    {
        return Order::select($column)->findorfail($orderID);
    }

    public function analyzeWeek($sellerID)
    {
        return Order::with('items')->select('id','user_id','price')->where('state',1)
                ->where('sellerID',$sellerID)->paginate(PAGINATION);
    }

    public function getOrdersBy(User $user)
    {
        $orders = $user->orders;
        
        foreach($orders as $order){
            $order->items;
            foreach($order->items as $item){
                $item = $this->item->getItemDataToDisplay($item);
                $item->feedback = $item->feedbacks()->select(['itemID','feedback'])->where('userID',$user->id)->first();
            }
        }
        return $orders;
    }

    public function getUserName(Order $order):string
    {
        return $order->user->name;
    }

    public function store($user)
    {
        $items = (new Basket($user))->all();  

        //itemsOfEachSeller associative array of associative array stor sellerId=>[price=>[],item=>[],count=>[]]
        return $this->saveOrders($this->item->getItemsOfEachSeller($items),$user);
    }
    
    private function getSendDate()
    {
        date_default_timezone_set('Africa/Cairo');
        $send_time = new DateTime('+2 day');
        return $send_time->format('Y-m-d H:i:s');
    }

    private function saveOrders(array $itemsOfEachSeller,$user){

        $sendDate = static::getSendDate();

        foreach($itemsOfEachSeller as $sellerKey=>$sellerValu){
            
            DB::beginTransaction();
            $order = Order::create(['price'=>array_sum($sellerValu['price']),'created_at'=>now(),
                'user_id'=>$user->id,'sellerID'=>$sellerKey,'send_time'=>$sendDate]);

            $stopFor = count($sellerValu['item']);
            for($count=0 ; $count < $stopFor ; $count++){
                $order->items()->attach($sellerValu['item'][$count],['item_count'=>$sellerValu['count'][$count]]);
            }

            $this->customer->setUserAsCustomer($user);

            $this->customer->addUserToSeller($user,$sellerKey);

            DB::commit();
            return true;
        }

        return false;

    }

    public function update($request)
    {
        $order = Order::findorfail($request->orderID);
        try{
            return $order->update($request->only('_token'));
        }catch(Exception $obj){
            return false;
        }
        
    }

    public function destroy($id)
    {
        $order = $this->getByID($id,['id']);
        return $order->delete();
    }

}