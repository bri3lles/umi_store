<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model { protected $fillable=['user_id','order_number','subtotal','shipping_cost','total','shipping_method','address','phone','payment_status','status','midtrans_order_id','paid_at','received_at']; protected $casts=['paid_at'=>'datetime','received_at'=>'datetime']; public function items(){return $this->hasMany(OrderItem::class);} public function user(){return $this->belongsTo(User::class);} public function returns(){return $this->hasMany(ReturnRequest::class,'order_id');} }
